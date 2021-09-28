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
use App\Models\Weight;

class SearchAllController extends Controller
{
    public function getFullProduct(Request $request)
    {
        try {
            $products = Product::where('status', '=', StatusSale::UP)->where('quantity', '>', 0)->get();
            $data = [];
            if (!empty($products)) {
                foreach ($products as $item) {
                    $data[] = [
                        "name" => $item->email,
                        "id" => $item->id,
                    ];
                }
            }
            return response()->json($products, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }

    public function postSearchProduct(Request $request)
    {
        $breadcrumbs = ['Search Product'];
        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(6)->get();
        $description = Description::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(4)->get();
        $weight = Weight::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(8)->get();

        $searchResult = Product::where('id', '=', $request->id)->where('quantity', '>', 0)->with(['weight', 'type', 'description'])
            ->whereHas('weight', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->whereHas('type', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->whereHas('description', function ($query) {
                $query->where('deleted_at', NULL);
            })
            ->orderBy('created_at', 'desc')->first();

        $post = Post::where('status', '=', StatusSale::UP)->with(['categorypost'])
            ->whereHas('categorypost', function ($query) {
                $query->where('deleted_at', NULL);
            })->orderBy('created_at', 'desc')->take(3)->get();
        return redirect()->route('admin.searchAll.postSearchProduct');
        // return view('sale.shop.search', compact('type', 'description', 'weight','post','breadcrumbs',));
    }

    public function searchProduct(Request $request)
    {
        $breadcrumbs = ['Search Product'];
        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(6)->get();
        $description = Description::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(4)->get();
        $weight = Weight::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->take(8)->get();
        $post = Post::where('status', '=', StatusSale::UP)->with(['categorypost'])
            ->whereHas('categorypost', function ($query) {
                $query->where('deleted_at', NULL);
            })->orderBy('created_at', 'desc')->take(3)->get();
        return view('sale.shop.search',compact('type', 'description', 'weight','post','breadcrumbs'));
    }
}
