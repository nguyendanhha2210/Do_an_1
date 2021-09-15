<?php

namespace App\Http\Controllers\Sale;

use App\Enums\OrderStatus;
use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Profit;
use App\Models\Shipping;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function manageOrder(Request $request)
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            $type = Type::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
            $breadcrumbs = ['Manage Order'];
            return view('sale.shop.orders.manageorder', ['breadcrumbs' => $breadcrumbs], compact('type'));
        }
    }

    public function getData()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            try {
                $id = Auth::guard('sales')->id();
                $orders = Order::where('customer_id', '=', $id)->with(['user', 'shipping'])->orderBy('created_at', 'desc')->paginate(5);
                return response()->json($orders, StatusCode::OK);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
            }
        }
    }

    public function cancelOrder(Request $request)
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            $validator = Validator::make($request->all(), [
                'order_destroy' => ['required'],
            ], [
                'order_destroy.required' => 'Nội dung hủy hàng chưa được nhập !',
            ]);
            if ($validator->fails()) {
                $message = array_combine($validator->errors()->keys(), $validator->errors()->all());
                return response()->json($message, StatusCode::BAD_REQUEST);
            }

            try {
                $idUser = Auth::guard('sales')->id();
                $id = $request->id;
                $orders = Order::where('customer_id', '=', $idUser)->where('id', '=', $id)->first();
                $orders->order_status = OrderStatus::FAILURE;
                $orders->order_destroy = $request->order_destroy;
                $orders->save();
                return response()->json($orders, StatusCode::OK);
            } catch (\Exception $e) {
                return response()->json(['message_failure' => $e->getMessage(), 'status' => StatusCode::INTERNAL_ERR], StatusCode::INTERNAL_ERR);
            }
        }
    }

    public function receivedOrder($id)
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            $idUser = Auth::guard('sales')->id();
            $orders = Order::where('customer_id', '=', $idUser)->where('id', '=', $id)->first();
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

    public function repurchase($id)
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            $idUser = Auth::guard('sales')->id();
            $orders = Order::where('customer_id', '=', $idUser)->where('id', '=', $id)->first();
            $orders->order_status = OrderStatus::ORDER;
            $orders->save();
        }
    }

    public function orderDetail($order_code)
    {
        if (!Auth::guard('sales')->check()) {
            return view('admin.users.login');
        }
        $type = Type::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $breadcrumbs = ['Order Detail'];

        $order_details = OrderDetail::with('product')->where('order_code', $order_code)->get();

        $order = Order::where('order_code', $order_code)->get();
        foreach ($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
            $order_status = $ord->order_status;
            $order_id = $ord->id;
        }

        $shipping = Shipping::where('id', $shipping_id)->first(); //Chỉ lấy 1 trường id thôi 
        $Order_detail_product = OrderDetail::with('product')->where('order_code', $order_code)->get();

        foreach ($Order_detail_product as $key => $order_d) {

            $product_coupon = $order_d->product_coupon;
        }

        if ($product_coupon != 'no') {
            $coupon = Coupon::where('code', $product_coupon)->first();
            $coupon_condition = $coupon->condition;
            $coupon_number = $coupon->number;
        } else {
            $coupon_condition = 2;
            $coupon_number = 0;
        }
        return view('sale.shop.orders.orderdetail')->with(compact('order_id', 'order_details', 'type', 'shipping', 'Order_detail_product', 'coupon_condition', 'coupon_number', 'order', 'order_status', 'breadcrumbs'));
    }
}
