<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\WeightRequest;
use App\Models\Weight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class WeightController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Weight List'];
            return view('admin.weights.index', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getData(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        $orderBy = $request->input('column');
        // $orderBy = "created_at";
        $orderByDir = $request->input('dir', 'asc');
        $usersQuery = Weight::query();
        switch ($orderByDir) {
            case 'asc':
                $usersQuery->orderBy($orderBy);
                break;
            case 'desc':
                $usersQuery->orderByDesc($orderBy);
                break;
        }
        return new DataTableCollectionResource($usersQuery->paginate(5, ['*'], 'page', $request->page));
    }

    public function weightAdd(Request $request)
    {
        if ($request->isMethod('get')) {
            $breadcrumbs = ['Add Weight'];
            $goBack = '/admin/description';
            return view('admin.weights.add', ['breadcrumbs' => $breadcrumbs, 'goBack' => $goBack]);
        }

        if ($request->isMethod('post')) {
            $weight = new Weight();
            $weight->weight = $request->weight;
            $weight->save();
            return redirect()->route('admin.weight.list');
        }
    }

    public function edit($id)
    {
        $data = Weight::find($id);
        $breadcrumbs = ['Edit Weight'];
        $goBack = '/admin/description';
        return view('admin.weights.edit', compact('data'), ['breadcrumbs' => $breadcrumbs, 'goBack' => $goBack]);
    }

    public function update(Request $request, $id)
    {
        $weight = Weight::find($id);
        $weight->weight = $request->nameWeight;
        $weight->save();
        return redirect()->route('admin.weight.list');
    }

    public function destroy($id)
    {
        $weight = Weight::find($id);
        $weight->delete();
    }
}
