<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Product;
use App\Models\Profit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // return view('layouts.admin.layout');
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        return view('admin.dashboards.index');
    }

    public function getDashboard()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $posts = Post::orderBy('views', 'DESC')->take(15)->get();
            $products = Product::orderBy('views', 'DESC')->take(15)->get();
            return response()->json(['posts' => $posts, 'products' => $products], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function getMap()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            // $profits = Profit::get();
            $profits = Profit::select('date',DB::raw('Sum(profit) AS totalProfit'))->groupBy('profits.date')->get(); //Lấy tổng lợi nhuận trong 1 ngày
            $data = [];
            foreach ($profits as $item) {
                $data[] = [
                    "label" => Carbon::parse($item->date)->format('Y/m/d'),
                    "value" => $item->totalProfit,
                ];
            }
            return response()->json($data, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
