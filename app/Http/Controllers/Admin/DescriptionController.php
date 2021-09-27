<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Enums\StatusSale;
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
            $sort_direction = request('sort_direction', 'desc');
            if (!in_array($sort_direction, ['asc', 'desc'])) {
                $sort_direction = 'desc';
            }
            $sort_field = request('sort_field', 'created_at');
            if (!in_array($sort_field, ['type'])) {
                $sort_field = 'created_at';
            }

            $description = Description::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('description', 'like', '%' . $search . '%');
                }
            })->orderBy($sort_field, $sort_direction)->paginate($paginate);

            return response()->json($description, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function create()
    {
        $breadcrumbs = ['Add Description'];
        $goBack = '/admin/description';
        return view('admin.descriptions.add', ['breadcrumbs' => $breadcrumbs, 'goBack' => $goBack]);
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
        $goBack = '/admin/description';
        return view('admin.descriptions.edit', compact('description'), ['breadcrumbs' => $breadcrumbs, 'goBack' => $goBack]);
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

    public function deleteAll(Request $request)
    {
        Description::whereIn('id', $request)->where('id', '!=', StatusSale::JUSTENTERD)->delete();
    }
}
