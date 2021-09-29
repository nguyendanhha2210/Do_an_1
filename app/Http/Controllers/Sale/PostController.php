<?php

namespace App\Http\Controllers\Sale;

use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Models\Order;
use App\Models\Post;
use App\Models\Type;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $breadcrumbs = ['Blog'];
        $breadcrumbs = [
            [
                'name' => 'Home',
                'url' => route('sale.index')

            ], 'Blog'
        ];
        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->get();
        return view("sale.post.index", ['breadcrumbs' => $breadcrumbs], compact('type'));
    }

    public function getData(Request $request)
    {
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $id_category = $request->id_category;
            $posts =  Post::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('title', 'like', '%' . $search . '%');
                }
            })->where(function ($q) use ($id_category) {
                if ($id_category) {
                    $q->where('id_category_post', '=', $id_category);
                }
            })->with(['categorypost'])
                ->whereHas('categorypost', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->orderBy('created_at', 'desc')->paginate($paginate);

            $recentPost =  Post::where('status', '=', StatusSale::UP)->with(['categorypost'])
                ->whereHas('categorypost', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->orderBy('created_at', 'desc')->take(3)->get();

            $categoryPost = CategoryPost::get();

            return response()->json(["post" => $posts, "recentPost" => $recentPost, "categoryPost" => $categoryPost], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function viewDetail($id)
    {
        $postDetail = Post::where('status', '=', StatusSale::UP)->with('categorypost')->where('id', $id)->get();
        $breadcrumbs = [
            [
                'name' => 'Home',
                'url' => route('sale.index')

            ], [
                'name' => 'Blog',
                'url' => route('sale.post.index')

            ], $postDetail[0]->title
        ];

        $type = Type::WHERE('deleted_at', NULL)->where('id', '!=', StatusSale::JUSTENTERD)->orderBy('created_at', 'desc')->get();

        return view("sale.post.detail", ['breadcrumbs' => $breadcrumbs], compact('type'));
    }

    public function getDetail($id)
    {
        try {
            $postDetail = Post::where('status', '=', StatusSale::UP)->with('categorypost')->where('id', $id)->get();
            $postView = Post::find($id);
            $postView->views = $postView->views + 1;
            $postView->save();

            return response()->json(["postDetail" => $postDetail], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }
}
