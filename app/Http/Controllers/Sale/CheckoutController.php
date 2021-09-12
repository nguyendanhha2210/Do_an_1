<?php

namespace App\Http\Controllers\Sale;

use App\Enums\OrderStatus;
use App\Enums\Payments;
use App\Enums\RoleStateType;
use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\Type;
use App\Models\User;
use App\Models\UserCoupon;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use phpseclib3\Math\BigInteger\Engines\OpenSSL;

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
            } elseif ($abc == Payments::PAYMENTVNPAY) {
                $breadcrumbs = ['Payment on vnpay '];
                return view('sale.shop.payments.onvnpay', ['breadcrumbs' => $breadcrumbs], compact('type'));
            } elseif ($abc == Payments::PAYMENTONEPAY) {
                $breadcrumbs = ['Payment on onepay '];
                return view('sale.shop.payments.ononepay', ['breadcrumbs' => $breadcrumbs], compact('type'));
            } elseif ($abc == Payments::PAYMENTMOMO) {
                $breadcrumbs = ['Payment on Momo '];
                return view('sale.shop.payments.onmomo', ['breadcrumbs' => $breadcrumbs], compact('type'));
            }
            // elseif ($abc == Payments::PAYMENTMOMO) {
            //     $breadcrumbs = ['Payment on Momo '];
            //     return view('sale.shop.payments.momo.paymomo.init_payment', ['breadcrumbs' => $breadcrumbs], compact('type'));
            // }
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

        return response()->json(route('sale.order.manageOrder'), StatusCode::OK);
    }

    public function checkoutPaypal(Request $request)
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
        $shipping->name = $request->shipping_name;
        $shipping->email = $request->shipping_email;
        $shipping->address = $request->shipping_address;
        $shipping->phone = $request->shipping_phone;
        $flag_shipping = $shipping->save();

        $shipping_id = $shipping->id;
        $checkout_code = substr(md5(microtime()), rand(0, 26), 5); //tạo rundle chữ và số xong lấy 5 kí tự

        $order = new Order();
        $order->customer_id = Auth::guard('sales')->id();
        // $order->shipping_id = $shipping_id;
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
        Session::forget('shipping');
    }

    public function checkoutVnpay(Request $request)
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
        Session::forget('shipping');


        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = url("/sale/success-vnpay");


        $vnp_TmnCode = "BHCR7T7U"; //Mã website tại VNPAY 
        $vnp_HashSecret = "LOZIHNNZNVGVOGSBDIZQXYKLBGIAJSYR"; //Chuỗi bí mật

        $vnp_TxnRef = $order->id; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toan don hang :' . $order->id;
        $vnp_OrderType = $order->order_code;

        $vnp_Amount = str_replace(',', '', $totalBill) * 100;
        $vnp_Locale = "vn";
        $vnp_BankCode = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        $date = new DateTime();
        $result = $date->format('Y-m-d-H-i-s');
        $krr = explode('-', $result);
        $vnp_ExpireDate = implode("", $krr);
        //Thanh toán
        $vnp_Bill_Mobile = $request->phone;
        $vnp_Bill_Email = $request->email;
        $fullName = trim($request->name);
        if (isset($fullName) && trim($fullName) != '') {
            $name = explode(' ', $fullName);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }
        $vnp_Bill_Address = $request->address;
        // Hóa đơn
        // $vnp_Inv_Phone = "1";
        // $vnp_Inv_Email = "1";
        // $vnp_Inv_Customer = "1";
        // $vnp_Inv_Address = "1";
        // $vnp_Inv_Company = "1";
        // $vnp_Inv_Taxcode = "1";
        // $vnp_Inv_Type = "1";
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
            "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
            "vnp_Bill_Email" => $vnp_Bill_Email,
            "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
            "vnp_Bill_LastName" => $vnp_Bill_LastName,
            "vnp_Bill_Address" => $vnp_Bill_Address,
            // "vnp_Bill_City" => $vnp_Bill_City,
            // "vnp_Bill_Country" => $vnp_Bill_Country,
            // "vnp_Inv_Phone" => $vnp_Inv_Phone,
            // "vnp_Inv_Email" => $vnp_Inv_Email,
            // "vnp_Inv_Customer" => $vnp_Inv_Customer,
            // "vnp_Inv_Address" => $vnp_Inv_Address,
            // "vnp_Inv_Company" => $vnp_Inv_Company,
            // "vnp_Inv_Taxcode" => $vnp_Inv_Taxcode,
            // "vnp_Inv_Type" => $vnp_Inv_Type
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $vnp_Url
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
        return request()->json($returnData);
    }

    public function successPay(Request $request)
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        }
        $type = Type::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $abc = $request->all();

        $payments = Payment::where('order_id', '=',  $request->order_id)->get();
        $countPayment = $payments->count();

        if ($countPayment > 0) {
            $payment = Payment::where('order_id', '=',  $request->order_id)->first();
            $payment->order_id = $request->vnp_TxnRef;
            $payment->customer_id = Auth::guard('sales')->id();
            $payment->total_money = $request->vnp_Amount;
            $payment->vnp_response = $request->vnp_ResponseCode;
            $payment->code_vnpay = $request->vnp_TransactionNo;
            $payment->code_back = $request->vnp_BankCode;
            $date_time = substr($request->vnp_PayDate, 0, 4) . '-' . substr($request->vnp_PayDate, 4, 2) . '-' . substr($request->vnp_PayDate, 6, 2) . ' ' . substr($request->vnp_PayDate, 8, 2) . ':' . substr($request->vnp_PayDate, 10, 2) . ':' . substr($request->vnp_PayDate, 12, 2);
            $payment->time = $date_time;
            $payment->save();
        } else {
            $payment = new Payment();
            $payment->order_id = $request->vnp_TxnRef;
            $payment->customer_id = Auth::guard('sales')->id();
            $payment->total_money = $request->vnp_Amount;
            $payment->vnp_response = $request->vnp_ResponseCode;
            $payment->code_vnpay = $request->vnp_TransactionNo;
            $payment->code_back = $request->vnp_BankCode;
            $date_time = substr($request->vnp_PayDate, 0, 4) . '-' . substr($request->vnp_PayDate, 4, 2) . '-' . substr($request->vnp_PayDate, 6, 2) . ' ' . substr($request->vnp_PayDate, 8, 2) . ':' . substr($request->vnp_PayDate, 10, 2) . ':' . substr($request->vnp_PayDate, 12, 2);
            $payment->time = $date_time;
            $payment->save();
        }

        $breadcrumbs = ['Success Order'];
        return view('sale.shop.payments.vnpay_php.successvnpay', ['breadcrumbs' => $breadcrumbs], compact('type', 'abc'));
    }

    public function checkoutOnepay(Request $request)
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
        Session::forget('shipping');

        $SECURE_SECRET = "A3EFDFABA8653DF2342E8DAC29B51AF0";
        $vpcURL = "https://mtf.onepay.vn/onecomm-pay/vpc.op";

        unset($_POST["https://mtf.onepay.vn/onecomm-pay/vpc.op"]);
        unset($_POST["SubButL"]);
        $stringHashData = "";
        ksort($_POST);
        $appendAmp = 0;

        foreach ($_POST as $key => $value) {
            if (strlen($value) > 0) {
                if ($appendAmp == 0) {
                    $vpcURL .= urlencode($key) . '=' . urlencode($value);
                    $appendAmp = 1;
                } else {
                    $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                }
                if ((strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                    $stringHashData .= $key . "=" . $value . "&";
                }
            }
        }

        $vpc_Txn_Secure_Hash = $_GET["vpc_SecureHash"];
        unset($_GET["vpc_SecureHash"]);

        $SECURE_SECRET = "A3EFDFABA8653DF2342E8DAC29B51AF0";
        $vpc_Txn_Secure_Hash = $_GET["vpc_SecureHash"];
        unset($_GET["vpc_SecureHash"]);
        $errorExists = false;
        ksort($_GET);

        $stringHashData = rtrim($stringHashData, "&");
        if (strlen($SECURE_SECRET) > 0) {
            $vpcURL .= "&vpc_SecureHash=" . strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*', $SECURE_SECRET)));
        }





        if (strlen($SECURE_SECRET) > 0 && $_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned") {
            $stringHashData = "";

            foreach ($_GET as $key => $value) {
                if ($key != "vpc_SecureHash" && (strlen($value) > 0) && ((substr($key, 0, 4) == "vpc_") || (substr($key, 0, 5) == "user_"))) {
                    $stringHashData .= $key . "=" . $value . "&";
                }
            }
            $stringHashData = rtrim($stringHashData, "&");
            if (strtoupper($vpc_Txn_Secure_Hash) == strtoupper(hash_hmac('SHA256', $stringHashData, pack('H*', $SECURE_SECRET)))) {
                $hashValidated = "CORRECT";
            } else {
                $hashValidated = "INVALID HASH";
            }
        } else {
            $hashValidated = "INVALID HASH";
        }



        return request()->json($vpcURL);
    }

    // public function checkoutMomo(Request $request)
    // {
    //     if (!Auth::guard('sales')->check()) {
    //         return redirect()->route('sale.users.login');
    //     }

    //     // dd($request->all());



    //     if (Session::get('coupon')) {
    //         foreach (Session::get('coupon') as $key => $cou) {
    //             $order_coupon = $cou['coupon_code'];
    //         }
    //     } else {
    //         $order_coupon = "no";
    //     }

    //     if (Session::get('totalPriceBill')) { //Lấy ra session của tổng tiền đơn hàng sau khi trừ coupon,..
    //         foreach (Session::get('totalPriceBill') as $key => $cart) {
    //             $totalBill =  $cart['money'];
    //         }
    //     }

    //     $couponUser = UserCoupon::where('user_id', '=', Auth::guard('sales')->id())->where('coupon_time', '>', 0)
    //         ->with(['coupon'])
    //         ->whereHas('coupon', function ($query) use ($order_coupon) {
    //             $query->where('code', $order_coupon);
    //         })->first();

    //     if ($couponUser) {
    //         $couponUser->coupon_time -= 1;
    //         $couponUser->save();
    //     }

    //     $shipping = new Shipping();
    //     $shipping->name = $request->name;
    //     $shipping->email = $request->email;
    //     $shipping->address = $request->address;
    //     $shipping->phone = $request->phone;
    //     $flag_shipping = $shipping->save();

    //     $shipping_id = $shipping->id;
    //     $checkout_code = substr(md5(microtime()), rand(0, 26), 5); //tạo rundle chữ và số xong lấy 5 kí tự

    //     $order = new Order();
    //     $order->customer_id = Auth::guard('sales')->id();
    //     $order->shipping_id = $shipping_id;
    //     $order->order_status = OrderStatus::ORDER;
    //     $order->order_code = $checkout_code;
    //     date_default_timezone_set('Asia/Ho_Chi_Minh');
    //     $order->order_date = now();
    //     $order->order_destroy = "";
    //     $order->total_bill = $totalBill;
    //     $flag_order = $order->save();

    //     if (Session::get('cart') == true) {
    //         foreach (Session::get('cart') as $key => $cart) {
    //             $order_details = new OrderDetail();
    //             $order_details->order_code = $checkout_code;
    //             $order_details->product_id = $cart['product_id'];
    //             $order_details->product_name = $cart['product_name'];
    //             $order_details->product_price = $cart['product_price'];
    //             $order_details->product_sales_quantity = $cart['product_qty'];
    //             $order_details->product_coupon =  $order_coupon;
    //             $order_details->save();
    //         }
    //     }

    //     //send mail confirm
    //     $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
    //     $title_mail = "Đơn đặt hàng ngày " . ' ' . $now;

    //     $customer = User::find(Auth::guard('sales')->id());

    //     $data['email'][] = $customer->email;
    //     //lay gio hang
    //     if (Session::get('cart') == true) {
    //         foreach (Session::get('cart') as $key => $cart_mail) {
    //             $cart_array[] = array(
    //                 'product_name' => $cart_mail['product_name'],
    //                 'product_price' => $cart_mail['product_price'],
    //                 'product_qty' => $cart_mail['product_qty']
    //             );
    //         }
    //     }

    //     // $shipping_array = array(
    //     //     // 'fee' =>  $fee,
    //     //     'customer_name' => $customer->name,
    //     //     'shipping_name' => $request->name,
    //     //     'shipping_email' => $request->email,
    //     //     'shipping_phone' => $request->phone,
    //     //     'shipping_address' => $request->address,
    //     // );

    //     //lay ma giam gia, lay coupon code
    //     // $ordercode_mail = array(
    //     //     'coupon_code' => $order_coupon,
    //     //     'order_code' => $checkout_code,
    //     //     'totalBill' => "100000",
    //     // );

    //     // Mail::send('sale.users.mail.sendOrder',  ['cart_array' => $cart_array, 'shipping_array' => $shipping_array, 'code' => $ordercode_mail], function ($message) use ($title_mail, $data) {
    //     //     $message->to($data['email'])->subject($title_mail); //send this mail with subject
    //     //     $message->from($data['email'], $title_mail); //send from this mail
    //     // });

    //     // Session::forget('coupon');
    //     // Session::forget('cart');
    //     // Session::forget('totalPriceBill');
    //     // Session::forget('shipping');


    //     $endpoint = "https://test-payment.momo.vn/gw_payment/payment/qr";
    //     $notifyUrl = "https://momo.vn";
    //     $returnUrl = "https://momo.vn";
    //     $extraData = "merchantName=MoMo Partner";

    //     $partnerCode = "MOMO809S20210911";
    //     $accessKey = "jzM0ArXzU6XhoJUd";
    //     $serectkey = "OJ7L1nR5X5BBvNsMUHGhAODDMP7vjySv";
    //     $orderId = $order->id; // Mã đơn hàng
    //     $orderInfo = "Thành Công !";
    //     $orderType = "momo_wallet";
    //     $amount =  $totalBill;

    //     $transId = "700569652782";
    //     // $requestId = time() . "";

    //     $requestId = "1631372800";
    //     $payType = "web";

    //     $requestType = "captureMoMoWallet";
    //     $extraData = "merchantName=Payment";
    //     // before sign HMAC SHA256 signature

    //     $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo  . "&notifyUrl=" . $notifyUrl . "&extraData=" . $extraData;
    //     $signature = hash_hmac("sha512", $rawHash, $serectkey);

    //     // $partnerCode="MOMOBKUN20180529";
    //     // $accessKey="klm05TvNBzhg7h7j";
    //     // $orderId="1631371994";
    //     // $requestId="1631378249";
    //     // $amount="10000";
    //     // $signature = "719b25b8371f8adf5fbc7d70650fc632849dbf83df543162b2cab6208df30ef9";
    //     // $requestType="captureMoMoWallet";


    //     $data = array(
    //         'partnerCode' => $partnerCode,
    //         'accessKey' => $accessKey,
    //         'requestId' => $requestId,
    //         'amount' => $amount,
    //         'orderId' => $orderId,
    //         'orderInfo' => $orderInfo,
    //         'orderType' => $orderType,
    //         'transId' => $transId,
    //         'returnUrl' => $returnUrl,
    //         'notifyUrl' => $notifyUrl,
    //         'extraData' => $extraData,
    //         'requestType' => $requestType,
    //         'signature' => $signature
    //     );

    //     //  $abc = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&signature=" . $signature . "&requestType=" . $requestType;

    //     $abc = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyUrl . "&extraData=" . $extraData . "&signature=" . $signature . "&requestType=" . $requestType;


    //     $endpoint = $endpoint . "?" . $abc;

    //     $returnData = array(
    //         'code' => '00',
    //         'message' => 'success',
    //         'data' => $endpoint
    //     );
    //     if (isset($_POST['redirect'])) {
    //         header('Location: ' . $endpoint);
    //         die();
    //     } else {
    //         echo json_encode($returnData);
    //     }
    //     return request()->json($returnData);
    // }


    // public function execPostRequest($url, $data)
    // {
    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt(
    //         $ch,
    //         CURLOPT_HTTPHEADER,
    //         array(
    //             'Content-Type: application/json',
    //             'Content-Length: ' . strlen($data)
    //         )
    //     );
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    //     curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //     //execute post
    //     $result = curl_exec($ch);
    //     //close connection
    //     curl_close($ch);
    //     return $result;
    // }

    public function checkoutMomo(Request $request)
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        }

        // dd($request->all());



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

        // $shipping_array = array(
        //     // 'fee' =>  $fee,
        //     'customer_name' => $customer->name,
        //     'shipping_name' => $request->name,
        //     'shipping_email' => $request->email,
        //     'shipping_phone' => $request->phone,
        //     'shipping_address' => $request->address,
        // );

        //lay ma giam gia, lay coupon code
        // $ordercode_mail = array(
        //     'coupon_code' => $order_coupon,
        //     'order_code' => $checkout_code,
        //     'totalBill' => "100000",
        // );

        // Mail::send('sale.users.mail.sendOrder',  ['cart_array' => $cart_array, 'shipping_array' => $shipping_array, 'code' => $ordercode_mail], function ($message) use ($title_mail, $data) {
        //     $message->to($data['email'])->subject($title_mail); //send this mail with subject
        //     $message->from($data['email'], $title_mail); //send from this mail
        // });

        // Session::forget('coupon');
        // Session::forget('cart');
        // Session::forget('totalPriceBill');
        // Session::forget('shipping');

        $endpoint = "https://test-payment.momo.vn/v2/gateway/pay";
        $partnerCode = "MOMO809S20210911";
        $accessKey = "jzM0ArXzU6XhoJUd";
        $serectkey = "OJ7L1nR5X5BBvNsMUHGhAODDMP7vjySv";
        $orderInfo = "Thanh toán qua MoMo";
        $amount = "10000";  
        $orderId = (time() + (10 * 24 * 60 * 60))."";
        $returnUrl = "";
        $notifyurl = "";
        $bankCode = "SML";
        $requestId = (time() + (7 * 24 * 60 * 60))."";
        $extraData = "";
        $requestType = "payWithMoMoATM";

        // $rawHashArr =  array(
        //     'partnerCode' => $partnerCode,
        //     'accessKey' => $accessKey,
        //     'requestId' => $requestId,
        //     'amount' => $amount,
        //     'orderId' => $orderId,
        //     'orderInfo' => $orderInfo,
        //     'bankCode' => $bankCode,
        //     'returnUrl' => $returnUrl,
        //     'notifyUrl' => $notifyurl,
        //     'extraData' => $extraData,
        //     'requestType' => $requestType
        // );

        $rawHash = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&bankCode=" . $bankCode . "&amount=" . $amount . "&orderId=" . $orderId. "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" . $extraData . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $serectkey);

        $data =  array(
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $order->id,
            'orderInfo' => $orderInfo,
            'returnUrl' => $returnUrl,
            'bankCode' => $bankCode,
            'notifyUrl' => $notifyurl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        //  $result = execPostRequest($endpoint, json_encode($data));
        //  $jsonResult = json_decode($result,true);  // decode json

        //  error_log( print_r( $jsonResult, true ) );
        //  header('Location: '.$jsonResult['payUrl']);

        $abc = "partnerCode=" . $partnerCode . "&accessKey=" . $accessKey . "&requestId=" . $requestId . "&amount=" . $amount . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&returnUrl=" . $returnUrl . "&notifyUrl=" . $notifyurl . "&extraData=" . $extraData . "&signature=" . $signature . "&requestType=" . $requestType;

        $endpoint = $endpoint . "?t=" . $abc;

        $returnData = array(
            'code' => '00',
            'message' => 'success',
            'data' => $endpoint
        );
        if (isset($_POST['redirect'])) {
            header('Location: ' . $endpoint);
            die();
        } else {
            echo json_encode($returnData);
        }
        return request()->json($returnData);
    }
}
