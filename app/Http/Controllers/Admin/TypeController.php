<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TypeRequest;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Type List'];
            return view('admin.types.index', ['breadcrumbs' => $breadcrumbs]);
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
            $types = Type::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('type', 'like', '%' . $search . '%');
                }
            })
                ->orderBy('created_at', 'desc')->paginate($paginate);


            return response()->json($types, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function create()
    {
        $breadcrumbs = ['Add New Type'];
        return view('admin.types.add', ['breadcrumbs' => $breadcrumbs]);
    }

    public function store(TypeRequest $request)
    {
        try {
            $type = new Type();
            $type->type = $request->type;
            $flag = $type->save();
            if ($flag) {
                return response()->json(route('admin.type.list'), StatusCode::OK);  //Lưu thành công gọi ra đg dẫn về list
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function edit($id)
    {
        $type = Type::find($id);
        $breadcrumbs = ['Edit Type'];
        return view('admin.types.edit', compact('type'), ['breadcrumbs' => $breadcrumbs]);
    }

    public function update(TypeRequest $request, $id)
    {
        try {
            $type = Type::find($id);
            $type->type = $request->type;
            $type->save();
            return response()->json(route('admin.type.list'), StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::INTERNAL_ERR);
        }
    }

    public function destroy($id)
    {
        $type = Type::find($id);
        $type->delete();
    }

    public function deleteAll(Request $request)
    {
        Type::whereIn('id', $request)->where('id', '!=', StatusSale::JUSTENTERD)->delete();
    }
}
