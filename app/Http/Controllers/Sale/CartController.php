<?php

namespace App\Http\Controllers\Sale;

use App\Enums\RoleStateType;
use App\Enums\StatusCode;
use App\Enums\StatusSale;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Type;
use App\Models\UserCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addCart(Request $request)
    {
        try {
            $session_id = substr(md5(microtime()), rand(0, 26), 5);
            $cart = Session::get('cart');
            if ($cart == true) {
                $is_avaiable = 0;
                foreach ($cart as $key => $val) {
                    if ($val['product_id'] == $request->id) {
                        $is_avaiable++;
                        // dd($val['product_qty'] + $request->qualityOrder);
                    }
                }
                if ($is_avaiable == 0) {
                    if ($request->qualityOrder) {
                        $cart[] = array(
                            'session_id' => $session_id,
                            'product_id' => $request->id,
                            'product_name' => $request->name,
                            'product_image' => $request->images,
                            'product_qty' => $request->qualityOrder,
                            'product_price' => $request->price,
                        );
                        Session::put('cart', $cart);
                    } else {
                        $cart[] = array(
                            'session_id' => $session_id,
                            'product_id' => $request->id,
                            'product_name' => $request->name,
                            'product_image' => $request->images,
                            'product_qty' => 1,
                            'product_price' => $request->price,
                        );
                        Session::put('cart', $cart);
                    }
                } else {
                    // if ($request->qualityOrder) {
                    //     $request->session()->forget('session_id', $session_id);
                    //     $cart[] = array(
                    //         'session_id' => $session_id,
                    //         'product_id' => $request->id,
                    //         'product_name' => $request->name,
                    //         'product_image' => $request->images,
                    //         'product_qty' => $val['product_qty'] + $request->qualityOrder,
                    //         'product_price' => $request->price,
                    //     );
                    //     Session::put('cart', $cart);
                    // } else {
                    //     $cart[] = array(
                    //         'session_id' => $session_id,
                    //         'product_id' => $request->id,
                    //         'product_name' => $request->name,
                    //         'product_image' => $request->images,
                    //         'product_qty' => $request->qualityOrder + 1,
                    //         'product_price' => $request->price,
                    //     );
                    //     Session::put('cart', $cart);
                    // }
                }
            } else {
                if ($request->qualityOrder) {
                    $cart[] = array(
                        'session_id' => $session_id,
                        'product_id' => $request->id,
                        'product_name' => $request->name,
                        'product_image' => $request->images,
                        'product_qty' => $request->qualityOrder,
                        'product_price' => $request->price,
                    );
                    Session::put('cart', $cart);
                } else {
                    $cart[] = array(
                        'session_id' => $session_id,
                        'product_id' => $request->id,
                        'product_name' => $request->name,
                        'product_image' => $request->images,
                        'product_qty' => 1,
                        'product_price' => $request->price,
                    );
                    Session::put('cart', $cart);
                }
            }
            Session::save();
            return response()->json(route('admin.cart.viewCart'), StatusCode::OK);
        } catch (\Exception $e) {
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
        $type = Type::WHERE('deleted_at', NULL)->orderBy('created_at', 'desc')->get();
        $breadcrumbs = [
            [
                'name' => 'Home',
                'url' => route('sale.index')

            ], 'View Cart'
        ];
        return view('sale.shop.viewcart', ['breadcrumbs' => $breadcrumbs], compact('type'));
    }

    public function delAllCart()
    {
        Session::forget('totalPriceBill'); //quên session lấy tổng tiền
        $cart = Session::get('cart');
        if ($cart == true) {
            Session::forget('cart');
            Session::forget('coupon');
            return redirect()->back()->with('message', 'Delete all successfully !');
        }
    }

    public function unsetCoupon()
    {
        Session::forget('totalPriceBill'); //quên session lấy tổng tiền
        Session::forget('coupon');
        return redirect()->back()->with('message', 'Delete successfully !');
    }

    public function updateCart(Request $request)
    {
        $data = $request->all();
        $storeNumber = Session::get('Trongkho');
        $cart = Session::get('cart');
        if ($cart == true) {
            foreach ($data['cart_qty'] as $key => $qty) //key là sesion id và qty là số lượng khi nhập
            {
                foreach ($cart as $session => $val) {
                    if ($val['session_id'] == $key) //nếu session hàng cũ = sesion hàng mới vừa nhập
                    {
                        $product = Product::find($val['product_id']);
                        if ($product['quantity'] >= $qty) {
                            $cart[$session]['product_qty'] = $qty;
                        } else {
                            $cart[$session]['product_qty'] = 1;
                            $storeNumber[] = array(
                                'nameProduct' =>  $product['name'],
                                'quantityStock' =>  $product['quantity']
                            );
                            Session::put('storeNumber', $storeNumber);
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
            return redirect()->back()->with('message', 'Update sản phẩm thành công');
        }
    }

    public function checkCoupon(Request $request)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $data = $request->all();
        $ma_coupon = $data['coupon'];

        $couponRequest = UserCoupon::where('user_id', '=', Auth::guard('sales')->id())
            ->with(['coupon'])
            ->whereHas('coupon', function ($query) use ($ma_coupon) {
                $query->where('code', $ma_coupon);
            })->first();

        if ($couponRequest) {
            if ($couponRequest->coupon->end_date > Carbon::now() && $couponRequest->coupon->start_date < Carbon::now()) {
                if ($couponRequest->coupon_time > 0) {
                    if ($couponRequest->coupon->status ==  StatusSale::SENT) {
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
                        return redirect()->back()->with('message', 'Áp dụng thành công');
                    } else {
                        return redirect()->back()->with('message', 'Mã giảm giá bị vô hiệu hóa !');
                    }
                } else {
                    return redirect()->back()->with('message', 'Mã giảm giá đã hết !');
                }
            } else {
                return redirect()->back()->with('message', 'Mã giảm giá đã hết hạn !');
            }
        } else {
            return redirect()->back()->with('message', 'Mã giảm giá không đúng hoặc bạn chưa đăng nhập !');
        }
    }
}
