<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\ExcelImports;
use App\Exports\ExcelExports;
use Illuminate\Support\Facades\Auth;
use Excel;

class ImportCSVController extends Controller
{
    public function importTypeCsv(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        $path1 = $request->file('file')->store('temp');
        $path = storage_path('app') . '/' . $path1;
        Excel::import(new ExcelImports, $path);
        return back();
    }

    public function exportTypeCsv(Request $request)
    {
        // dd((array)$request);
        // dd(gettype($request));
        return (new ExcelExports($request))->download('types.xlsx');
    }
}
