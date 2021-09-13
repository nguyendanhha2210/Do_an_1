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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
                $file->move('uploads', $fileName);
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

    public function productImage()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Product Image'];
            return view('admin.products.productimage', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getProductImage(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $productImages =  ProductImage::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('product_id', '=', $search);
                }
            })->with(['product'])
                ->whereHas('product', function ($query) {
                    $query->where('deleted_at', NULL);
                })->orderBy('created_at', 'desc')->paginate($paginate);

            return response()->json($productImages, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function updateProductImage(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            try {
                $productImage = ProductImage::where('product_id', $id)->firstOrFail();
                $productImage->product_id = $id;
                $file_1 = $request->image_1;
                if ($file_1 != null) {
                    $fileName_1 = $file_1->getClientOriginalName();
                    $file_1->move('uploads', $fileName_1);
                    $productImage->image_1 = $fileName_1;
                }

                $file_2 = $request->image_2;
                if ($file_2 != null) {
                    $fileName_2 = $file_2->getClientOriginalName();
                    $file_2->move('uploads', $fileName_2);
                    $productImage->image_2 = $fileName_2;
                }

                $file_3 = $request->image_3;
                if ($file_3 != null) {
                    $fileName_3 = $file_3->getClientOriginalName();
                    $file_3->move('uploads', $fileName_3);
                    $productImage->image_3 = $fileName_3;
                }

                $file_4 = $request->image_4;
                if ($file_4 != null) {
                    $fileName_4 = $file_4->getClientOriginalName();
                    $file_4->move('uploads', $fileName_4);
                    $productImage->image_4 = $fileName_4;
                }

                $productImage->save();
                return response()->json(route("admin.productImage.list"), StatusCode::OK);
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
            }
        }
    }

    public function detailProductImage()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Product Image'];
            return view('admin.products.imagedetail', ['breadcrumbs' => $breadcrumbs]);
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
