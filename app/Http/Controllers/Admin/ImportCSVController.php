<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ExcelDescriptionExports;
use App\Exports\ExcelTypeExports;
use App\Http\Controllers\Controller;
use App\Imports\ExcelDecriptionImports;
use App\Imports\ExcelTypeImports;
use Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImportCSVController extends Controller
{
    public function importTypeCsv(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        $path1 = $request->file('file')->store('temp');
        $path = storage_path('app') . '/' . $path1;
        Excel::import(new ExcelTypeImports, $path);
        return back();
    }

    public function exportTypeCsv($array)
    {
        $typesArray = explode(',', $array);
        return (new ExcelTypeExports($typesArray))->download('types.xlsx');
    }

    public function importDescriptionCsv(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        $path1 = $request->file('file')->store('temp');
        $path = storage_path('app') . '/' . $path1;
        Excel::import(new ExcelDecriptionImports, $path);
        return back();
    }

    public function exportDescriptionCsv($array)
    {
        $decriptionsArray = explode(',', $array);
        return (new ExcelDescriptionExports($decriptionsArray))->download('decriptions.xlsx');
    }
}
