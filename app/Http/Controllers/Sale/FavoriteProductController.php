<?php

namespace App\Http\Controllers\Sale;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FavoriteProductController extends Controller
{
    public function addFavorite(Request $request)
    {
        try {
            $session_id = substr(md5(microtime()), rand(0, 26), 5);
            $favorite = Session::get('favorite');
            if ($favorite == true) {
                $is_avaiable = 0;
                foreach ($favorite as $key => $val) {
                    if ($val['product_id'] == $request->id) {
                        $is_avaiable++;
                        // dd($val['product_qty'] + $request->qualityOrder);
                    }
                }
                if ($is_avaiable == 0) {
                    if ($request->qualityOrder) {
                        $favorite[] = array(
                            'session_id' => $session_id,
                            'product_id' => $request->id,
                            'product_name' => $request->name,
                            'product_image' => $request->images,
                            'product_qty' => $request->qualityOrder,
                            'product_price' => $request->price,
                        );
                        Session::put('favorite', $favorite);
                    } else {
                        $favorite[] = array(
                            'session_id' => $session_id,
                            'product_id' => $request->id,
                            'product_name' => $request->name,
                            'product_image' => $request->images,
                            'product_qty' => 1,
                            'product_price' => $request->price,
                        );
                        Session::put('favorite', $favorite);
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
                    $favorite[] = array(
                        'session_id' => $session_id,
                        'product_id' => $request->id,
                        'product_name' => $request->name,
                        'product_image' => $request->images,
                        'product_qty' => $request->qualityOrder,
                        'product_price' => $request->price,
                    );
                    Session::put('favorite', $favorite);
                } else {
                    $favorite[] = array(
                        'session_id' => $session_id,
                        'product_id' => $request->id,
                        'product_name' => $request->name,
                        'product_image' => $request->images,
                        'product_qty' => 1,
                        'product_price' => $request->price,
                    );
                    Session::put('favorite', $favorite);
                }
            }
            Session::save();
            // return response()->json(route('admin.cart.viewCart'), StatusCode::OK);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
        }
    }

    public function delProductFavorite($session_id)
    {
        $favorite = Session::get('favorite');
        if ($favorite == true) {
            foreach ($favorite as $key => $val) {
                if ($val['session_id'] == $session_id) {
                    unset($favorite[$key]);
                }
            }
            Session::put('favorite', $favorite);
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }
}
