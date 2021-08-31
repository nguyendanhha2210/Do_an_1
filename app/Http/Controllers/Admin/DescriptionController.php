<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DescriptionRequest;
use App\Models\Description;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DescriptionController extends Controller
{

    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Description List'];
            return view('admin.descriptions.index', ['breadcrumbs' => $breadcrumbs]);
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
            $description = Description::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('description', 'like', '%' . $search . '%');
                }
            })->orderBy('created_at', 'desc')->paginate($paginate);

            return response()->json($description, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function create()
    {
        $breadcrumbs = ['Add Description'];
        return view('admin.descriptions.add', ['breadcrumbs' => $breadcrumbs]);
    }

    public function store(DescriptionRequest $request)
    {
        try {
            $description = new Description();
            $description->description = $request->description;
            $flag = $description->save();
            if ($flag) {
                return response()->json(route('admin.description.list'), StatusCode::OK);  //Lưu thành công gọi ra đg dẫn về list
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function edit($id)
    {
        $description = Description::find($id);
        $breadcrumbs = ['Edit Description'];
        return view('admin.descriptions.edit', compact('description'), ['breadcrumbs' => $breadcrumbs]);
    }

    public function update(DescriptionRequest $request, $id)
    {
        try {
            $description = Description::find($id);;
            $description->description = $request->description;
            $flag = $description->save();
            if ($flag) {
                return response()->json(route('admin.description.list'), StatusCode::OK);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function destroy($id)
    {
        $description = Description::find($id);
        $description->delete();
    }
}
