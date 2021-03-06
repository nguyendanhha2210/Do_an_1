<?php

namespace App\Http\Controllers\Sale;

use App\Enums\OrderStatus;
use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderWithStatusController extends Controller
{
    public function getOrderConfirm()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            try {
                $id = Auth::guard('sales')->id();
                $orders = Order::where('customer_id', '=', $id)->where('order_status', '=', OrderStatus::ORDER)->with(['user', 'shipping'])->orderBy('created_at', 'desc')->paginate(5);
                return response()->json($orders, StatusCode::OK);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
            }
        }
    }

    public function getOrderDeliver()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            try {
                $id = Auth::guard('sales')->id();
                $orders = Order::where('customer_id', '=', $id)->where('order_status', '=', OrderStatus::SHIPPING)->with(['user', 'shipping'])->orderBy('created_at', 'desc')->paginate(5);
                return response()->json($orders, StatusCode::OK);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
            }
        }
    }

    public function getOrderReceive()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            try {
                $id = Auth::guard('sales')->id();
                $orders = Order::where('customer_id', '=', $id)->where('order_status', '=', OrderStatus::SUCCESS)->with(['user', 'shipping'])->orderBy('created_at', 'desc')->paginate(5);
                return response()->json($orders, StatusCode::OK);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
            }
        }
    }

    public function getOrderEvaluat()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            try {
                $id = Auth::guard('sales')->id();
                $orders = Order::where('customer_id', '=', $id)->where('order_status', '=', OrderStatus::EVALUATED)->with(['user', 'shipping'])->orderBy('created_at', 'desc')->paginate(5);
                return response()->json($orders, StatusCode::OK);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
            }
        }
    }

    public function getOrderCancel()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            try {
                $id = Auth::guard('sales')->id();
                $orders = Order::where('customer_id', '=', $id)->where('order_status', '=', OrderStatus::FAILURE)->with(['user', 'shipping'])->orderBy('created_at', 'desc')->paginate(5);
                return response()->json($orders, StatusCode::OK);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
            }
        }
    }

    public function getOrderReturn()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            try {
                $id = Auth::guard('sales')->id();
                $orders = Order::where('customer_id', '=', $id)->where('order_status', '=', OrderStatus::RETURNS)->with(['user', 'shipping'])->orderBy('created_at', 'desc')->paginate(5);
                return response()->json($orders, StatusCode::OK);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
            }
        }
    }

    public function getCountStatus()
    {
        if (!Auth::guard('sales')->check()) {
            return redirect()->route('sale.users.login');
        } else {
            try {
                $id = Auth::guard('sales')->id();
                $countOrder = Order::where('customer_id', '=', $id)->where('order_status', '=', OrderStatus::ORDER)->count();
                $countshipping = Order::where('customer_id', '=', $id)->where('order_status', '=', OrderStatus::SHIPPING)->count();
                $countSuccess = Order::where('customer_id', '=', $id)->where('order_status', '=', OrderStatus::SUCCESS)->count();
                $countFailure = Order::where('customer_id', '=', $id)->where('order_status', '=', OrderStatus::FAILURE)->count();
                $countEvaluate = Order::where('customer_id', '=', $id)->where('order_status', '=', OrderStatus::EVALUATED)->count();
                $countReturn = Order::where('customer_id', '=', $id)->where('order_status', '=', OrderStatus::RETURNS)->count();

                return response()->json(
                    [
                    "countOrder" => $countOrder,
                    "countshipping" => $countshipping,
                    "countSuccess" => $countSuccess,
                    "countFailure" => $countFailure,
                    "countEvaluate" => $countEvaluate,
                    "countReturn" => $countReturn,
                ],
                    StatusCode::OK
                );
            } catch (\Exception $e) {
                return response()->json($e->getMessage(), StatusCode::INTERNAL_ERR);
            }
        }
    }
}
