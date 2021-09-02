<?php

namespace App\Http\Controllers\Sale;

use App\Enums\OrderStatus;
use App\Enums\RoleStateType;
use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use App\Models\Type;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkOut()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            $type = Type::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
            $breadcrumbs = ['Checkout'];
            return view('sale.shop.checkout', ['breadcrumbs' => $breadcrumbs], compact('type'));
        }
    }

    public function checkoutCart(Request $request)
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        }
        if (Session::get('coupon')) {
            foreach (Session::get('coupon') as $key => $cou) {
                $order_coupon = $cou['coupon_code'];
            }
        } else {
            $order_coupon = "no";
        }

        if (Session::get('totalPriceBill')) { //Lấy ra session của tổng tiền đơn hàng sau khi trừ coupon,..
            foreach (Session::get('totalPriceBill') as $key => $cart) {
                $totalBill =  $cart['money'];
            }
        }

        $couponList = Coupon::where('code', '=', $order_coupon)->first();
        if ($couponList) {
            $couponList->time -= 1;
            $couponList->save();
        }

        $shipping = new Shipping();
        $shipping->name = $request->name;
        $shipping->email = $request->email;
        $shipping->address = $request->address;
        $shipping->phone = $request->phone;
        $flag_shipping = $shipping->save();

        $shipping_id = $shipping->id;
        $checkout_code = substr(md5(microtime()), rand(0, 26), 5); //tạo rundle chữ và số xong lấy 5 kí tự

        $order = new Order();
        $order->customer_id = Auth::guard('sales')->id();
        $order->shipping_id = $shipping_id;
        $order->order_status = OrderStatus::ORDER;
        $order->order_code = $checkout_code;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->order_date = now();
        $order->order_destroy = "";
        $order->total_bill = $totalBill;
        $flag_order = $order->save();

        if (Session::get('cart') == true) {
            foreach (Session::get('cart') as $key => $cart) {
                $order_details = new OrderDetail();
                $order_details->order_code = $checkout_code;
                $order_details->product_id = $cart['product_id'];
                $order_details->product_name = $cart['product_name'];
                $order_details->product_price = $cart['product_price'];
                $order_details->product_sales_quantity = $cart['product_qty'];
                $order_details->product_coupon =  $order_coupon;
                $order_details->save();
            }
        }

        // if ($flag_shipping && $flag_order) {
        //     $id_customer = Auth::guard('sales')->id();
        //     $user = User::where('id', $id_customer)->where('role_id', RoleStateType::SALER)->first();

        //     // $shippingData = [
        //     //     'name' => $request->name,
        //     //     'email' =>  $request->email,
        //     //     'address' => $request->address,
        //     //     'phone' => $request->phone,
        //     // ];

        //     // $order = Session::get('cart');
        //     // // dd($order);
        //     // Mail::send('admin.users.mail.sendOrder', ['shippingData' => $order], function ($message) use ($user) {
        //     //     $message->to($user->email);
        //     // });


        //     // Mail::send('admin.users.mail.sendOrder', ['shippingData' => $shipping->id, 'order' => $order], function ($message) use ($user) {
        //     //     $message->to($user->email);
        //     // });
        // }

        Session::forget('coupon');
        Session::forget('cart');
        Session::forget('totalPriceBill');
    }
}
