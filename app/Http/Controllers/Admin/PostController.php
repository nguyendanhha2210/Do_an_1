<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function updatePostStatus(Request $request, $id)
    {
        try {
            $query = Post::findOrFail($id);
            if ($request->status == 1) {
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

    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Article List'];
            return view('admin.posts.index', ['breadcrumbs' => $breadcrumbs]);
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

            $sort_direction = request('sort_direction', 'desc');
            if (!in_array($sort_direction, ['asc', 'desc'])) {
                $sort_direction = 'desc';
            }
            $sort_field = request('sort_field', 'created_at');
            if (!in_array($sort_field, ['title', 'desc', 'content'])) {
                $sort_field = 'created_at';
            }

            $posts =  Post::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('title', 'like', '%' . $search . '%');
                }
            })->with(['categorypost'])
                ->whereHas('categorypost', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->orderBy($sort_field, $sort_direction)->paginate($paginate);
            return response()->json($posts, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function create()
    {
        $data = [];
        $category_post = CategoryPost::get();
        $data = collect([
            'category_post' => $category_post,
        ]);
        return $data;
    }

    public function store(Request $request)
    {
        try {
            $product = new Post();
            $product->title = $request->title;

            $file = $request->images;
            $fileName = $file->getClientOriginalName();
            $file->move('uploads/posts', $fileName);
            $product->images = $fileName;

            $product->id_category_post = $request->id_category_post;
            $product->desc = $request->desc;
            $product->status = StatusSale::DOWN;
            $product->content = $request->content;
            $product->views = 0;
            $product->save();
            return response()->json(route("admin.post.list"), StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function update(PostRequest $request, $id)
    {
        try {
            $product = Post::where('id', $id)->firstOrFail();
            $product->title = $request->title;

            $file = $request->images;
            if ($file != null) {
                $fileName = $file->getClientOriginalName();
                $file->move('uploads/posts', $fileName);
                $product->images = $fileName;
            }

            $product->id_category_post = $request->id_category_post;
            $product->desc = $request->desc;
            $product->content = $request->content;

            $product->save();
            return response()->json(route("admin.post.list"), StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
    }
}
