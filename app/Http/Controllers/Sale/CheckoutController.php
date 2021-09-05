<?php

namespace App\Http\Controllers\Sale;

use App\Enums\OrderStatus;
use App\Enums\Payments;
use App\Enums\RoleStateType;
use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use App\Models\Type;
use App\Models\User;
use App\Models\UserCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function checkOut(Request $request)
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            $type = Type::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
            $abc = $request->payment_option;
            if ($abc == Payments::PAYMENTDELIVERY) {
                $breadcrumbs = ['Payment on delivery '];
                return view('sale.shop.payments.ondelivery', ['breadcrumbs' => $breadcrumbs], compact('type'));
            } elseif ($abc == Payments::PAYMENTPAYPAL) {
                $breadcrumbs = ['Payment on paypal '];
                return view('sale.shop.payments.onpaypal', ['breadcrumbs' => $breadcrumbs], compact('type'));
            }
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

        $couponUser = UserCoupon::where('user_id', '=', Auth::guard('sales')->id())->where('coupon_time', '>', 0)
            ->with(['coupon'])
            ->whereHas('coupon', function ($query) use ($order_coupon) {
                $query->where('code', $order_coupon);
            })->first();

        if ($couponUser) {
            $couponUser->coupon_time -= 1;
            $couponUser->save();
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


        //send mail confirm
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_mail = "Đơn đặt hàng ngày " . ' ' . $now;

        $customer = User::find(Auth::guard('sales')->id());

        $data['email'][] = $customer->email;
        //lay gio hang
        if (Session::get('cart') == true) {
            foreach (Session::get('cart') as $key => $cart_mail) {
                $cart_array[] = array(
                    'product_name' => $cart_mail['product_name'],
                    'product_price' => $cart_mail['product_price'],
                    'product_qty' => $cart_mail['product_qty']
                );
            }
        }
        //lay shipping
        //   if(Session::get('fee')==true){
        //     $fee = Session::get('fee').'k';
        //   }else{
        //     $fee = '25k';
        //   }


        $shipping_array = array(
            // 'fee' =>  $fee,
            'customer_name' => $customer->name,
            'shipping_name' => $request->name,
            'shipping_email' => $request->email,
            'shipping_phone' => $request->phone,
            'shipping_address' => $request->address,
        );

        //lay ma giam gia, lay coupon code
        $ordercode_mail = array(
            'coupon_code' => $order_coupon,
            'order_code' => $checkout_code,
            'totalBill' => $totalBill,
        );

        Mail::send('sale.users.mail.sendOrder',  ['cart_array' => $cart_array, 'shipping_array' => $shipping_array, 'code' => $ordercode_mail], function ($message) use ($title_mail, $data) {
            $message->to($data['email'])->subject($title_mail); //send this mail with subject
            $message->from($data['email'], $title_mail); //send from this mail
        });

        Session::forget('coupon');
        Session::forget('cart');
        Session::forget('totalPriceBill');
    }
}
