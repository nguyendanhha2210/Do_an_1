<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Models\Description;
use App\Models\Post;
use App\Models\Product;
use App\Models\Type;

class SearchAllController extends Controller
{
    public function getFullProduct(Request $request)
    {
        try {
            $products = Product::where('status', '=', StatusSale::UP)->where('quantity', '>', 0)->get();
            return response()->json($products, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }

    public function searchProduct(Request $request)
    {
        $breadcrumbs = [
            [
                'name' => 'Home',
                'url' => route('sale.index')

            ], 'Search Product'
        ];
        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(6)->get();
        $description = Description::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(4)->get();
        $post = Post::where('status', '=', StatusSale::UP)->with(['categorypost'])
            ->whereHas('categorypost', function ($query) {
                $query->where('deleted_at', NULL);
            })->orderBy('created_at', 'desc')->take(3)->get();

        $resultSearch = Product::where('id', '=', $request->id)->where('quantity', '>', 0)->with(['type', 'description'])
            ->whereHas('type', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->whereHas('description', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->orderBy('created_at', 'desc')->first();

        return view('sale.shop.search', compact('type', 'description','post', 'breadcrumbs', 'resultSearch'));
    }
}
