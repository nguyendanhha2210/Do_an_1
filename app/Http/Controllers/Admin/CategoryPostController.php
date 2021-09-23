<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryPostRequest;
use App\Models\CategoryPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryPostController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Category Post List'];
            return view('admin.categoryposts.index', ['breadcrumbs' => $breadcrumbs]);
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
            $types = CategoryPost::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                }
            })->orderBy('created_at', 'desc')->paginate($paginate);

            return response()->json($types, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function create()
    {
        $breadcrumbs = ['Add New Type'];
        $goBack = '/admin/category-post';
        return view('admin.categoryposts.add', ['breadcrumbs' => $breadcrumbs, 'goBack' => $goBack]);
    }

    public function store(CategoryPostRequest $request)
    {
        try {
            $type = new CategoryPost();
            $type->name = $request->name;
            $type->desc = $request->desc;
            $flag = $type->save();
            if ($flag) {
                return response()->json(route('admin.categorypost.list'), StatusCode::OK);  //Lưu thành công gọi ra đg dẫn về list
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function edit($id)
    {
        $category = CategoryPost::find($id);
        $breadcrumbs = ['Edit Type'];
        $goBack = '/admin/category-post';
        return view('admin.categoryposts.edit', compact('category'), ['breadcrumbs' => $breadcrumbs, 'goBack' => $goBack]);
    }

    public function update(CategoryPostRequest $request, $id)
    {
        try {
            $type = CategoryPost::find($id);
            $type->name = $request->name;
            $type->desc = $request->desc;
            $type->save();
            return response()->json(route('admin.categorypost.list'), StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }

    public function destroy($id)
    {
        $type = CategoryPost::find($id);
        $type->delete();
    }
}
