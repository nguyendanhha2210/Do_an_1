<?php

namespace App\Http\Controllers\Sale;

use App\Enums\StatusCode;
use App\Enums\StatusCoupon;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Type;
use App\Models\UserCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
        try {
            $session_id = substr(md5(microtime()), rand(0, 26), 5);
            $cart = Session::get('cart');
            $key = $request->id . $request->price;
            if (empty($cart[$key])) {
                if ($request->qualityOrder) {
                    $cart[$key] = array(
                        'session_id' => $session_id,
                        'product_id' => $request->id,
                        'product_name' => $request->name,
                        'product_image' => $request->images,
                        'product_qty' => $request->qualityOrder,
                        'product_price' => $request->price,
                        'product_weight' => $request->weight,
                    );
                } else {
                    $cart[$key] = array(
                        'session_id' => $session_id,
                        'product_id' => $request->id,
                        'product_name' => $request->name,
                        'product_image' => $request->images,
                        'product_qty' => 1,
                        'product_price' => $request->price,
                        'product_weight' => $request->weight,
                    );
                }
            } else {
                if ($request->qualityOrder) {
                    $cart[$key]['product_qty'] = $cart[$key]['product_qty'] + $request->qualityOrder;
                } else {
                    $cart[$key]['product_qty'] = $cart[$key]['product_qty'] + 1;
                }
            }
            Session::put('cart', $cart);
            Session::save();
            return response()->json(route('admin.cart.viewCart'), StatusCode::OK);
        } catch (\Exception$e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function delProductCart($session_id)
    {
        $cart = Session::get('cart');
        if ($cart == true) {
            foreach ($cart as $key => $val) {
                if ($val['session_id'] == $session_id) {
                    unset($cart[$key]);
                }
            }
            Session::put('cart', $cart);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function viewCart()
    {
        $type = Type::WHERE('deleted_at', null)->orderBy('created_at', 'desc')->get();
        $breadcrumbs = [
            [
                'name' => 'Home',
                'url' => route('sale.index'),

            ], 'View Cart',
        ];
        return view('sale.shop.viewcart', ['breadcrumbs' => $breadcrumbs], compact('type'));
    }

    public function delAllCart()
    {
        Session::forget('totalPriceBill'); //qu??n session l???y t???ng ti???n
        $cart = Session::get('cart');
        if ($cart == true) {
            Session::forget('cart');
            Session::forget('coupon');
            return redirect()->back()->with('message', 'Delete all successfully !');
        }
    }

    public function unsetCoupon()
    {
        Session::forget('totalPriceBill'); //qu??n session l???y t???ng ti???n
        Session::forget('coupon');
        return redirect()->back()->with('message', 'Delete successfully !');
    }

    public function updateCart(Request $request)
    {
        $data = $request->all();
        $storeNumber = Session::get('Trongkho'); //T???o 1 session s???n ph???m ???? trong kho h??ng
        $cart = Session::get('cart');
        if ($cart == true) {
            foreach ($data['cart_qty'] as $key => $qty) { //key l?? sesion id v?? qty l?? s??? l?????ng khi nh???p {
                foreach ($data['cart_wei'] as $keyWeight => $wei) {
                    foreach ($cart as $session => $val) {
                        if ($val['session_id'] == $key && $key == $keyWeight) { //n???u session h??ng c?? = sesion h??ng m???i v???a nh???p { {
                            $product = Product::find($val['product_id']);
                            if ($product['quantity'] >= ($qty * $wei)) {
                                $cart[$session]['product_qty'] = $qty;
                            } else {
                                $cart[$session]['product_qty'] = 1;
                                $storeNumber[] = array(
                                    'nameProduct' => $product['name'],
                                    'quantityStock' => $product['quantity'],
                                );
                                Session::put('storeNumber', $storeNumber);
                            }
                        }
                    }
                }
            }
        }
        Session::put('cart', $cart);

        $storeNumber = Session::get('storeNumber');
        if ($storeNumber == true) {
            return redirect()->back()->with('storeNumber', $storeNumber);
        } else {
            return redirect()->back()->with('message', 'Update s???n ph???m th??nh c??ng');
        }
    }

    public function checkCoupon(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data = $request->all();
        $ma_coupon = $data['coupon'];

        $couponRequest = UserCoupon::where('user_id', '=', Auth::guard('sales')->id())->where('statusUse', StatusCoupon::SAVE)
            ->with(['coupon'])
            ->whereHas('coupon', function ($query) use ($ma_coupon) {
                $query->where('code', $ma_coupon);
            })->first();

        if ($couponRequest) {
            if ($couponRequest->coupon->end_date > Carbon::now() && $couponRequest->coupon->start_date < Carbon::now()) {
                if ($couponRequest->coupon_time > 0) {
                    if ($couponRequest->coupon->status == StatusSale::SENT) {
                        $coupon_session = Session::get('coupon');
                        if ($coupon_session) {
                            $cou[] = array(
                                'coupon_code' => $couponRequest->coupon->code,
                                'coupon_condition' => $couponRequest->coupon->condition,
                                'coupon_number' => $couponRequest->coupon->number,
                                'coupon_time' => $couponRequest->coupon_time,
                            );
                            Session::put('coupon', $cou);
                        } else {
                            $cou[] = array(
                                'coupon_code' => $couponRequest->coupon->code,
                                'coupon_condition' => $couponRequest->coupon->condition,
                                'coupon_number' => $couponRequest->coupon->number,
                                'coupon_time' => $couponRequest->coupon_time,
                            );
                            Session::put('coupon', $cou);
                        }
                        Session::save();
                        return redirect()->back()->with('message', '??p d???ng th??nh c??ng');
                    } else {
                        return redirect()->back()->with('message', 'M?? gi???m gi?? b??? v?? hi???u h??a !');
                    }
                } else {
                    return redirect()->back()->with('message', 'M?? gi???m gi?? ???? h???t !');
                }
            } else {
                return redirect()->back()->with('message', 'M?? gi???m gi?? ???? h???t h???n !');
            }
        } else {
            return redirect()->back()->with('message', 'M?? gi???m gi?? kh??ng ????ng ho???c b???n ch??a ????ng nh???p !');
        }
    }

    public function addProductAccessories(Request $request)
    {
        try {
            $cart = Session::get('cart');
            $products = Product::whereIn('id', $request->all())->with('minWeightProduct')->get();

            foreach ($products as $product) {
                $session_id = substr(md5(microtime()), rand(0, 26), 5);
                $key = (string) $product->id . (string) $product->minWeightProduct->price;
                if (empty($cart[$key])) {
                    if ($product->minWeightProduct->weight <= $product->quantity) {
                        $cart[$key] = array(
                            'session_id' => $session_id,
                            'product_id' => (string) $product->id,
                            'product_name' => $product->name,
                            'product_image' => $product->images,
                            'product_qty' => 1,
                            'product_price' => (string) $product->minWeightProduct->price,
                            'product_weight' => $product->minWeightProduct->weight,
                        );
                    }
                } else {
                    if (($product->minWeightProduct->weight * ($cart[$key]['product_qty'] + 1)) <= $product->quantity) { //X??t xem s??? lg m???i nh??n v???i kh???i l?????ng c?? l???n h??n kh???i lg c??n trong gi??? h??ng k ?
                        $cart[$key]['product_qty'] = $cart[$key]['product_qty'] + 1;
                    }
                }
            }
            Session::put('cart', $cart);
            return response()->json(route('admin.cart.viewCart'), StatusCode::OK);
        } catch (\Exception$e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }
}
