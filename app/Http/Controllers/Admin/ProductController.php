<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Description;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Type;
use App\Models\Weight;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function update_product_status(Request $request, $id)
    {
        try {
            $query = Product::findOrFail($id);
            if ($request->status == StatusSale::DOWN) {
                $query->status = StatusSale::UP;
            } else {
                $query->status = StatusSale::DOWN;
            }
            $query->save();
            return response()->json($query, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Product List'];
            return view('admin.products.index', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getData(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $products =  Product::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                }
            })->with(['weight', 'type', 'description', 'warehouse'])
                ->whereHas('weight', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('type', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('description', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('warehouse', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->orderBy('created_at', 'desc')->paginate($paginate);

            return response()->json($products, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function create()
    {
        $data = [];
        $type_product = Type::get();
        $weight_product = Weight::get();
        $description_product = Description::get();
        $data = collect([
            'type_product' => $type_product,
            'weight_product' => $weight_product,
            'description_product' => $description_product,
        ]);
        return $data;
    }

    public function update(ProductRequest $request, $id)
    {
        try {
            $product = Product::where('id', $id)->firstOrFail();
            $product->name = $request->name;

            $file = $request->images;
            if ($file != null) {
                $fileName = $file->getClientOriginalName();
                $file->move('uploads/products', $fileName);
                $product->images = $fileName;
            }

            $product->price = $request->price;
            $product->type_id = $request->type_id;
            $product->weight_id = $request->weight_id;
            $product->description_id = $request->description_id;
            $product->content = $request->content;
            $product->status = StatusSale::DOWN;

            $product->save();
            return response()->json(route("admin.product.list"), StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    // public function productImage()
    // {
    //     if (!Auth::guard('admin')->check()) {
    //         return view('admin.users.login');
    //     } else {
    //         $breadcrumbs = ['Product Image'];
    //         return view('admin.products.productimage', ['breadcrumbs' => $breadcrumbs]);
    //     }
    // }

    // public function getProductImage(Request $request)
    // {
    //     if (!Auth::guard('admin')->check()) {
    //         return view('admin.users.login');
    //     }
    //     try {
    //         $paginate = $request->paginate;
    //         $search = $request->search;
    //         $productImages =  ProductImage::where(function ($q) use ($search) {
    //             if ($search) {
    //                 $q->where('product_id', '=', $search);
    //             }
    //         })->with(['product'])
    //             ->whereHas('product', function ($query) {
    //                 $query->where('deleted_at', NULL);
    //             })->orderBy('created_at', 'desc')->paginate($paginate);

    //         return response()->json($productImages, StatusCode::OK);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
    //     }
    // }

    public function saveProductImage(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            try {
                DB::beginTransaction();
                if (!empty($request->images)) {
                    $insertDataImages = [];
                    foreach ($request->images as $key => $file) {
                        $fileName = $file->getClientOriginalName();
                        $file->move('uploads/products', $fileName);

                        $insertDataImages[] = [
                            'product_id' => $request->productId,
                            'url' => $fileName,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                    }
                    ProductImage::insert($insertDataImages);
                }
                DB::commit();
                return response()->json(route("admin.product.list"), StatusCode::OK);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
            }
        }
    }

    public function addProductImage($id)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Add Product Image'];
            return view('admin.products.imageadd', ['breadcrumbs' => $breadcrumbs, 'productId' => $id]);
        }
    }

    public function detailProductImage($id)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Detail Product Image'];
            $goBack = '/admin/product';
            $productImages = ProductImage::where('product_id', $id)->get();
            if ($productImages) {
                return view('admin.products.imagedetail', ['breadcrumbs' => $breadcrumbs, 'data' => $productImages, 'goBack' => $goBack]);
            }
        }
    }


    public function getDetailProductImage(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $productImages =  ProductImage::where('product_id', $id)->with(['product'])->whereHas('product', function ($query) {
                $query->where('deleted_at', NULL);
            })->orderBy('created_at', 'desc')->get();
            return response()->json($productImages, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }
}
