<?php

namespace App\Http\Controllers\Sale;

use App\Enums\SortByOption;
use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Description;
use App\Models\Post;
use App\Models\Product;
use App\Models\Type;
use App\Models\Weight;
use Illuminate\Http\Request;
use Symfony\Component\Console\Descriptor\Descriptor;
use Illuminate\Support\Facades\Session;
use App\Models\Evaluate;
use App\Models\UserCoupon;
use App\Models\WeightProduct;
use PhpParser\Node\Stmt\Catch_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function index()
    {
        $breadcrumbs = [
            [
                'name' => 'Home',
                'url' => route('sale.index')

            ], 'Shop'
        ];

        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(6)->get();
        $description = Description::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(4)->get();

        $post = Post::where('status', '=', StatusSale::UP)->with(['categorypost'])
            ->whereHas('categorypost', function ($query) {
                $query->where('deleted_at', NULL);
            })->orderBy('created_at', 'desc')->take(3)->get();

        return view("sale.shop.shop", ['breadcrumbs' => $breadcrumbs], compact('type', 'description', 'post'));
    }

    public function getData(Request $request)
    {
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $statusView = $request->statusView;

            if ($statusView == SortByOption::NEW) {
                $products =  Product::where(function ($q) use ($search) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', 0)->where('quantity', '>', 0)->with(['type', 'description'])
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', 0)->where('quantity', '>', 0)->with(['type', 'description'])
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', 0)->where('quantity', '>', 0)->with(['type', 'description'])
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', 0)->where('quantity', '>', 0)->with(['type', 'description'])
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', 0)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas('type', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->whereHas('description', function ($query) {
                        $query->where('deleted_at', NULL);
                    })
                    ->orderBy('name', 'desc')->paginate($paginate);
            }

            $maxSold = Product::where('status', '=', 0)->where('quantity', '>', 0)->orderBy('product_sold', 'desc')->get(); //Lấy ra sp bán dc nhiều nhất

            return response()->json(["products" => $products, "maxSold" => $maxSold[0]], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function productDetail(Request $request, $id)
    {
        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(6)->get();
        $description = Description::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(4)->get();

        $post = Post::where('status', '=', StatusSale::UP)->with(['categorypost'])
            ->whereHas('categorypost', function ($query) {
                $query->where('deleted_at', NULL);
            })->orderBy('created_at', 'desc')->take(3)->get();

        $product =  Product::where('id', '=', $id)->where('quantity', '>', 0)
            ->with(['type', 'description', 'productImages', 'weightProducts'])
            ->first();

        $breadcrumbs = [
            [
                'name' => 'Home',
                'url' => route('sale.index')

            ], [
                'name' => 'Shop',
                'url' => route('sale.shop.index')

            ], $product->name
        ];

        $productView = Product::find($id);
        $productView->views = $productView->views + 1;
        $productView->save();

        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $viewed = Session::get('viewed');
        if ($viewed == true) {
            $is_avaiable = 0;
            foreach ($viewed as $key => $val) {
                if ($val['product_id'] == $productView->id) {
                    $is_avaiable++;
                    // dd($val['product_qty'] + $request->qualityOrder);
                }
            }
            if ($is_avaiable == 0) {
                if ($productView->qualityOrder) {
                    $viewed[] = array(
                        'session_id' => $session_id,
                        'product_id' => $productView->id,
                        'product_name' => $productView->name,
                        'product_image' => $productView->images,
                        'product_qty' => $productView->qualityOrder,
                        'product_price' => $productView->price,
                    );
                    Session::put('viewed', $viewed);
                } else {
                    $viewed[] = array(
                        'session_id' => $session_id,
                        'product_id' => $productView->id,
                        'product_name' => $productView->name,
                        'product_image' => $productView->images,
                        'product_qty' => 1,
                        'product_price' => $productView->price,
                    );
                    Session::put('viewed', $viewed);
                }
            } else {
            }
        } else {
            if ($request->qualityOrder) {
                $viewed[] = array(
                    'session_id' => $session_id,
                    'product_id' => $productView->id,
                    'product_name' => $productView->name,
                    'product_image' => $productView->images,
                    'product_qty' => $productView->qualityOrder,
                    'product_price' => $productView->price,
                );
                Session::put('viewed', $viewed);
            } else {
                $viewed[] = array(
                    'session_id' => $session_id,
                    'product_id' => $productView->id,
                    'product_name' => $productView->name,
                    'product_image' => $productView->images,
                    'product_qty' => 1,
                    'product_price' => $productView->price,
                );
                Session::put('viewed', $viewed);
            }
        }
        Session::save();


        return view('sale.shop.detailproduct', ['breadcrumbs' => $breadcrumbs], compact('type', 'description', 'product', 'post'));
    }

    public function fillEvaluated(Request $request, $id)
    {
        $countEvaluate = Evaluate::where('product_id', $id)->get()->count();
        return response()->json($countEvaluate, StatusCode::OK);
    }

    public function delViewedProduct($session_id)
    {
        $viewed = Session::get('viewed');
        if ($viewed == true) {
            foreach ($viewed as $key => $val) {
                if ($val['session_id'] == $session_id) {
                    unset($viewed[$key]);
                }
            }
            Session::put('viewed', $viewed);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function productRelated($id)
    {
        try {
            $product = Product::find($id);
            $products =  Product::Where('status', '=', 0)->where('quantity', '>', 0)
                ->where('type_id', $product->type_id)
                ->whereNotIn('id', [$id])
                ->with(['type', 'description'])
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
        $breadcrumbs = [
            [
                'name' => 'Home',
                'url' => route('sale.index')

            ], [
                'name' => 'Shop',
                'url' => route('sale.shop.index')

            ], 'Type Product'
        ];

        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(6)->get();
        $description = Description::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(4)->get();

        $post = Post::where('status', '=', StatusSale::UP)->with(['categorypost'])
            ->whereHas('categorypost', function ($query) {
                $query->where('deleted_at', NULL);
            })->orderBy('created_at', 'desc')->take(3)->get();

        $productType =  Product::where('type_id', '=', $id)->get();

        return view('sale.shop.typeproduct', ['breadcrumbs' => $breadcrumbs], compact('type', 'description', 'productType', 'post'));
    }

    public function getTypeProduct(Request $request, $id)
    {
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $statusView = $request->statusView;

            if ($statusView == SortByOption::NEW) {
                $products =  Product::where(function ($q) use ($search) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('type_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('type_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('type_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('type_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('type_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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

    //Show view Description product
    public function chooseDescription($id)
    {
        $breadcrumbs = [
            [
                'name' => 'Home',
                'url' => route('sale.index')

            ], [
                'name' => 'Shop',
                'url' => route('sale.shop.index')

            ], 'Description Product'
        ];
        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(6)->get();
        $description = Description::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(4)->get();
        $weight = Weight::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(8)->get();

        $post = Post::where('status', '=', StatusSale::UP)->with(['categorypost'])
            ->whereHas('categorypost', function ($query) {
                $query->where('deleted_at', NULL);
            })->orderBy('created_at', 'desc')->take(3)->get();
        $productDescription =  Product::where('description_id', '=', $id)->get();

        return view('sale.shop.descriptionproduct', ['breadcrumbs' => $breadcrumbs], compact('type', 'description',  'productDescription', 'post'));
    }

    //Show data Description product
    public function getDescriptionProduct(Request $request, $id)
    {
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $statusView = $request->statusView;

            if ($statusView == SortByOption::NEW) {
                $products =  Product::where(function ($q) use ($search) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('description_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('description_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('description_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('description_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('description_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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

    //Show view Weight product
    public function chooseWeight($id)
    {
        $breadcrumbs = [
            [
                'name' => 'Home',
                'url' => route('sale.index')

            ], [
                'name' => 'Shop',
                'url' => route('sale.shop.index')

            ], 'Weight Product'
        ];

        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(6)->get();
        $description = Description::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(4)->get();
        $weight = Weight::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(8)->get();

        $post = Post::where('status', '=', StatusSale::UP)->with(['categorypost'])
            ->whereHas('categorypost', function ($query) {
                $query->where('deleted_at', NULL);
            })->orderBy('created_at', 'desc')->take(3)->get();
        $productWeight =  Product::where('weight_id', '=', $id)->get();

        return view('sale.shop.weightproduct', ['breadcrumbs' => $breadcrumbs], compact('type', 'description',  'productWeight', 'post'));
    }

    //Show data Weight product
    public function getWeightProduct(Request $request, $id)
    {
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $statusView = $request->statusView;

            if ($statusView == SortByOption::NEW) {
                $products =  Product::where(function ($q) use ($search) {
                    if ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('weight_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('weight_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('weight_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('weight_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('type', function ($q) use ($search) {
                                $q->where('type', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas('description', function ($q) use ($search) {
                                $q->where('description', 'like', '%' . $search . '%');
                            });
                        });
                        $q->orWhere(function ($query) use ($search) {
                            $query->whereHas(function ($q) use ($search) {
                                $q->where('like', '%' . $search . '%');
                            });
                        });
                    }
                })->Where('status', '=', StatusSale::UP)->where('weight_id', '=', $id)->where('quantity', '>', 0)->with(['type', 'description'])
                    ->whereHas(function ($query) {
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

    public function fillWeightProduct(Request $request, $id)
    {
        try {
            $weightProducts = WeightProduct::where('product_id', $id)->get()->count();
            if ($weightProducts == 1) {
                $weightProducts = WeightProduct::where('product_id', $id)->first();
                $priceWeightProduct = $weightProducts->price;
                $weightProduct = $weightProducts->weight;
                return response()->json(["priceWeightProduct" => $priceWeightProduct, "weightProduct" => $weightProduct], StatusCode::OK);
            } else {
                $weightProductMax = WeightProduct::where('product_id', $request->id)->max('price');
                $weightProductMin = WeightProduct::where('product_id', $request->id)->min('price');
                $priceWeightProduct = '';
                return response()->json(["weightProductMax" => $weightProductMax, "weightProductMin" => $weightProductMin, 'priceWeightProduct' => $priceWeightProduct], StatusCode::OK);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function chooseWeightProduct(Request $request)
    {
        try {
            $weightProduct = WeightProduct::find($request->id);
            return response()->json($weightProduct, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    //Show Accessory shop
    public function getAccessory(Request $request, $id)
    {
        try {
            $product = Product::find($id);
            $productAccessory =  Product::Where('status', '=', 0)->where('quantity', '>', 0)
                ->where('type_id', $product->type_id)
                ->where('description_id', $product->description_id)
                ->whereNotIn('id', [$id])
                ->with(['type', 'description'])
                ->whereHas(function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('type', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('description', function ($query) {
                    $query->where('deleted_at', NULL);
                })->take(4)->orderBy('price', 'asc')->get();

            return response()->json(["productAccessory" => $productAccessory], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    //Show coupon shop
    public function getCouponStore()
    {
        try {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $couponStores =  Coupon::Where('status', '=', 0)->where('time', '>', 0)
                ->whereDate('start_date', '<=', now())
                ->whereDate('end_date', '>=', now())
                ->orderBy('created_at', 'desc')->get();

            return response()->json(["couponStores" => $couponStores], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function saveCouponStore($id)
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            try {
                DB::beginTransaction();
                $useCoupon = UserCoupon::where('coupon_id', $id)->first();
                if ($useCoupon) {
                    $mess = "Coupon has been saved!";
                } else {
                    $coupon = Coupon::find($id);
                    $coupon->time =  $coupon->time - 1;
                    $coupon->update();

                    $userCoupon = new UserCoupon();
                    $userCoupon->user_id = Auth::guard('sales')->id();
                    $userCoupon->coupon_id = $id;
                    $userCoupon->coupon_name = $coupon->name;
                    $userCoupon->coupon_time = 1;
                    $userCoupon->save();
                    $mess = "Coupon saved successfully ! See details ?";
                    DB::commit();
                }

                return response()->json(["mess" => $mess, "url" => route('sale.contact.index')], StatusCode::OK);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
            }
        }
    }

    public function getCouponUser()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        }else{
            try{
                $userId = Auth::guard('sales')->id();
                $userCoupons = UserCoupon::where(function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                    $query->where('coupon_time', '>', 0);
                })->get();
                return response()->json(["userCoupons" => $userCoupons], StatusCode::OK);
            }catch(\Exception $e) {
                return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
            }
            }
    }
}
