<?php

namespace App\Http\Controllers\Ship;

use App\Enums\LimitTimeForgot;
use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TypeRequest;
use App\Models\Order;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrderStatus;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Profit;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function orderList()
    {
        if (!Auth::guard('ship')->check()) {
            return view('ship.users.login');
        } else {
            $breadcrumbs = ['Order List'];
            return view('ship.orders.index', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getData(Request $request)
    {
        if (!Auth::guard('ship')->check()) {
            return view('ship.users.login');
        }
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $statusOrder = $request->statusOrder;
            $orders = Order::where('order_status', '=', OrderStatus::SHIPPING)
                ->where(function ($q) use ($search) {
                    if ($search) {
                        $q->where('order_date', 'like', '%' . $search . '%');
                    }
                })->where(function ($st) use ($statusOrder) {
                    if ($statusOrder) {
                        $st->where('order_status', '=', $statusOrder);
                    }
                })
                ->with(['user', 'shipping'])
                ->whereHas('user', function ($query) {
                    $query->where('deleted_at', NULL);
                })->whereHas('shipping', function ($query) {
                    $query->where('deleted_at', NULL);
                })
                ->orderBy('created_at', 'desc')->paginate($paginate);

            return response()->json($orders, StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function delivered($id)
    {
        if (!Auth::guard('ship')->check()) {
            return redirect()->route('ship.users.login');
        } else {
            $orders = Order::where('id', '=', $id)->first();
            $orders->order_status = OrderStatus::SUCCESS;
            $orders->save();

            if ($orders->order_status == OrderStatus::SUCCESS) {
                $orderCode = $orders->order_code;
                $orderDetail = OrderDetail::where('order_code', $orderCode)->get();
                $product = Product::all();
                $cost = 0;
                foreach ($orderDetail as $key => $item) {
                    foreach ($product as $value => $que) {
                        if ($item['product_id'] == $que['id']) {
                            $intoMoney = $que['import_price'] * $item['product_sales_quantity'];
                            $cost += $intoMoney;
                        }
                    }
                }
                $profit = new Profit();
                $profit->order_code = $orderCode;
                $profit->revenue = $orders->total_bill;
                $profit->cost = $cost;
                $profit->profit = $profit->revenue - $profit->cost;
                date_default_timezone_set('Asia/Ho_Chi_Minh');
                $profit->date = now();
                $profit->save();
            }
        }
    }
}
