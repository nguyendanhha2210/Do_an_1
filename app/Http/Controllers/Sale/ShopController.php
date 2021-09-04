<?php

namespace App\Http\Controllers\Sale;

use App\Enums\SortByOption;
use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Models\Description;
use App\Models\Product;
use App\Models\Type;
use App\Models\Weight;
use Illuminate\Http\Request;
use Symfony\Component\Console\Descriptor\Descriptor;

class ShopController extends Controller
{
    public function index()
    {
        $breadcrumbs = ['Shop'];
        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->get();
        $description = Description::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->get();
        $weight = Weight::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->get();

        return view("sale.shop.shop", ['breadcrumbs' => $breadcrumbs], compact('type', 'description', 'weight'));
    }

    public function getData(Request $request)
    {
        // try {
        //     $paginate = $request->paginate;
        //     $search = $request->search;
        //     $statusView = $request->statusView;
        //     $products =  Product::where(function ($q) use ($search) {
        //         if ($search) {
        //             $q->where('name', 'like', '%' . $search . '%');
        //         }
        //     })->Where('status', '=', 0)->where('quantity', '>', 0)->with(['weight', 'type', 'description'])
        //         ->whereHas('weight', function ($query) {
        //             $query->where('deleted_at', NULL);
        //         })
        //         ->whereHas('type', function ($query) {
        //             $query->where('deleted_at', NULL);
        //         })
        //         ->whereHas('description', function ($query) {
        //             $query->where('deleted_at', NULL);
        //         })
        //         ->orderBy('created_at', 'desc')->paginate($paginate);

        //     return response()->json($products, StatusCode::OK);
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        // }

        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $statusView = $request->statusView;

            if ($statusView == SortByOption::NEW) {
                $products =  Product::where(function ($q) use ($search) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    }
                })->Where('status', '=', 0)->where('quantity', '>', 0)->with(['weight', 'type', 'description'])
                    ->whereHas('weight', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->whereHas('type', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->whereHas('description', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->orderBy('created_at', 'desc')->paginate($paginate);
            } elseif ($statusView == SortByOption::PRICEINCREASE) {
                $products =  Product::where(function ($q) use ($search) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    }
                })->Where('status', '=', 0)->where('quantity', '>', 0)->with(['weight', 'type', 'description'])
                    ->whereHas('weight', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->whereHas('type', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->whereHas('description', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->orderBy('price', 'asc')->paginate($paginate);
            } elseif ($statusView == SortByOption::REDUCEDPRICE) {
                $products =  Product::where(function ($q) use ($search) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    }
                })->Where('status', '=', 0)->where('quantity', '>', 0)->with(['weight', 'type', 'description'])
                    ->whereHas('weight', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->whereHas('type', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->whereHas('description', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->orderBy('price', 'desc')->paginate($paginate);
            } elseif ($statusView == SortByOption::AToZ) {
                $products =  Product::where(function ($q) use ($search) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    }
                })->Where('status', '=', 0)->where('quantity', '>', 0)->with(['weight', 'type', 'description'])
                    ->whereHas('weight', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->whereHas('type', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->whereHas('description', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->orderBy('name', 'asc')->paginate($paginate);
            } elseif ($statusView == SortByOption::ZToA) {
                $products =  Product::where(function ($q) use ($search) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    }
                })->Where('status', '=', 0)->where('quantity', '>', 0)->with(['weight', 'type', 'description'])
                    ->whereHas('weight', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->whereHas('type', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->whereHas('description', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->orderBy('name', 'desc')->paginate($paginate);
            }


            return response()->json($products, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function productDetail($id)
    {
        $type = Type::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $description = Description::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $weight = Weight::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $product =  Product::where('id', '=', $id)->where('quantity', '>', 0)->with(['weight', 'type', 'description', 'productImages'])
            ->whereHas('weight', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->whereHas('type', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->whereHas('description', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->whereHas('productImages', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->orderBy('price', 'ASC')->get();
        $breadcrumbs = ['Detail Product'];

        $productView = Product::find($id);
        $productView->views = $productView->views + 1;
        $productView->save();

        return view('sale.shop.detailproduct', ['breadcrumbs' => $breadcrumbs], compact('type', 'description', 'weight', 'product'));
    }

    public function productRelated($id)
    {
        try {
            $product = Product::find($id);
            $products =  Product::Where('status', '=', 0)->where('quantity', '>', 0)
                ->where('type_id', $product->type_id)
                ->whereNotIn('id', [$id])
                ->with(['weight', 'type', 'description'])
                ->whereHas('weight', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('type', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('description', function ($query) {
                    $query->where('deleted_at', NULL);
                })->take(3)->get();

            return response()->json($products, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function chooseType($id)
    {
        $breadcrumbs = ['Type Product'];
        $type = Type::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $description = Description::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $weight = Weight::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $productType =  Product::where('type_id', '=', $id)->get();

        return view('sale.shop.typeproduct', ['breadcrumbs' => $breadcrumbs], compact('type', 'description', 'weight', 'productType'));
    }

    public function getTypeProduct(Request $request, $id)
    {
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $product =  Product::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                }
            })->where('quantity', '>', 0)->where('type_id', '=', $id)
                ->with(['weight', 'type', 'description'])
                ->whereHas('weight', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('type', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('description', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->orderBy('created_at', 'DESC')->paginate($paginate);

            return response()->json($product, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    //Show view Description product
    public function chooseDescription($id)
    {
        $breadcrumbs = ['Description Product'];
        $type = Type::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $description = Description::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $weight = Weight::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $productDescription =  Product::where('description_id', '=', $id)->get();

        return view('sale.shop.descriptionproduct', ['breadcrumbs' => $breadcrumbs], compact('type', 'description', 'weight', 'productDescription'));
    }

    //Show data Description product
    public function getDescriptionProduct(Request $request, $id)
    {
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $product =  Product::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                }
            })->where('quantity', '>', 0)->where('description_id', '=', $id)
                ->with(['weight', 'type', 'description'])
                ->whereHas('weight', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('type', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('description', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->orderBy('created_at', 'DESC')->paginate($paginate);

            return response()->json($product, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    //Show view Weight product
    public function chooseWeight($id)
    {
        $breadcrumbs = ['Description Product'];
        $type = Type::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $description = Description::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $weight = Weight::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $productWeight =  Product::where('weight_id', '=', $id)->get();

        return view('sale.shop.weightproduct', ['breadcrumbs' => $breadcrumbs], compact('type', 'description', 'weight', 'productWeight'));
    }

    //Show data Weight product
    public function getWeightProduct(Request $request, $id)
    {
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $product =  Product::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                }
            })->where('quantity', '>', 0)->where('weight_id', '=', $id)
                ->with(['weight', 'type', 'description'])
                ->whereHas('weight', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('type', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('description', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->orderBy('created_at', 'DESC')->paginate($paginate);

            return response()->json($product, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }
}
