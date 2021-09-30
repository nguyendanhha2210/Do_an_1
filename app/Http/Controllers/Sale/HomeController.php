<?php

namespace App\Http\Controllers\Sale;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use App\Models\Type;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featureProduct = Product::where('status', '=', 0)->where('quantity', '>', 0)
            ->with(['type', 'description'])
            ->whereHas('type', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->whereHas('description', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->orderBy('created_at', 'desc')->get();

        $sellingProduct = Product::where('status', '=', 0)->where('quantity', '>', 0)
            ->with(['type', 'description'])
            ->whereHas('type', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->whereHas('description', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->orderBy('price', 'asc')->get();

        $post = Post::where('status', '=', 0)
            ->with('categoryPost')
            ->whereHas('categoryPost', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->orderBy('created_at', 'desc')->take(3)->get();

        $type = Type::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        return view('sale.index.index', compact('type', 'featureProduct', 'sellingProduct', 'post'));
    }

    public function getFeatureProduct(Request $request)
    {
        try {
            $products =  Product::where('status', '=', 0)->where('quantity', '>', 0)
                ->with(['type', 'description'])
                ->whereHas('type', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('description', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->orderBy('created_at', 'desc')->get();

            return response()->json($products, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function getSellingProduct(Request $request)
    {
        try {
            $products =  Product::where('status', '=', 0)->where('quantity', '>', 0)
                ->with(['type', 'description'])
                ->whereHas('type', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('description', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->orderBy('price', 'ASC')->get();

            return response()->json($products, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function error404()
    {
        return view('errors.404');
    }

    public function error500()
    {
        return view('errors.500');
    }

    public function quickViewShop(Request $request)
    {
        try {
            $productQuick = Product::where('id', $request->id)->where('quantity', '>', 0)
                ->with(['type', 'description', 'productImages'])
                ->whereHas('type', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('description', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->orderBy('created_at', 'desc')->first();

            $id = $productQuick->id;
            $idType = $productQuick->type_id;
            $idDecr = $productQuick->description_id;

            $productTogether =  Product::Where('status', '=', 0)->where('quantity', '>', 0)
                ->where('type_id', $idType)
                ->where('description_id', $idDecr)
                ->whereNotIn('id', [$id])
                ->with(['type', 'description'])
                ->whereHas('type', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->whereHas('description', function ($query) {
                    $query->where('deleted_at', NULL);
                })->take(3)->orderBy('price', 'asc')->get();

            return response()->json(["productQuick" => $productQuick, "productTogether" => $productTogether], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
