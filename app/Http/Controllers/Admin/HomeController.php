<?php

namespace App\Http\Controllers\Admin;

use App\Enums\OrderStatus;
use App\Enums\RoleStateType;
use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Profit;
use App\Models\User;
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

    public function getGeneralStatistical()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            // $profits = Profit::all()->sum("profit");
            $countProducts = Product::where('status', '=', StatusSale::UP)->count(); //Đếm số sản phẩm đang bày bán
            $countPosts = Post::where('status', '=', StatusSale::UP)->count(); //Đếm số sản phẩm đang bày bán
            $countOrders = Order::where('order_status', '=', OrderStatus::SUCCESS)->count(); //Đếm số sản phẩm đang bày bán
            $countUsers = User::where('role_id', '=', RoleStateType::SALER)->count(); //Đếm số sản phẩm đang bày bán

            $list = [
                "Products" => $countProducts,
                "Posts" =>  $countPosts,
                "Orders" => $countOrders,
                "Users" => $countUsers,
            ];

            foreach ($list as $item => $value) {
                $data[] = [
                    "label" => $item,
                    "value" => $value,
                ];
            }
            return response()->json(["general" => $data], StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
