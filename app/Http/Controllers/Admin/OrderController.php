<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\User;
use App\Models\WareHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\OrderDate;
use Carbon\Carbon;

Barryvdh\DomPDF\ServiceProvider::class;

class OrderController extends Controller
{
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        } else {
            $breadcrumbs = ['Order List'];
            return view('admin.orders.index', ['breadcrumbs' => $breadcrumbs]);
        }
    }

    public function getData(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        try {
            $paginate = $request->paginate;
            $search = $request->search;
            $statusOrder = $request->statusOrder;
            $types = Order::where(function ($q) use ($search) {
                if ($search) {
                    $q->where('order_date', 'like', '%' . $search . '%');
                }
            })->where(function ($st) use ($statusOrder) {
                if ($statusOrder) {
                    $st->where('order_status', '=', $statusOrder);
                }
            })->orderBy('created_at', 'desc')->paginate($paginate);

            return response()->json($types, StatusCode::OK);
        } catch (\Exception$e) {
            return response()->json(['error' => $e->getMessage()], StatusCode::NOT_FOUND);
        }
    }

    public function show(Request $request, $order_code)
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.users.login');
        }
        $breadcrumbs = ['Order Detail'];
        $goBack = '/admin/order';

        $order_details = OrderDetail::with('product')->where('order_code', $order_code)->get();

        $order = Order::where('order_code', $order_code)->get();

        foreach ($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
            $order_status = $ord->order_status;
            $order_id = $ord->id;
        }

        $customer = User::where('id', $customer_id)->first(); //Chỉ lấy 1 trường id thôi
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

        return view('admin.orders.detailorder')->with(compact('order_id', 'order_details', 'customer', 'shipping', 'Order_detail_product', 'coupon_condition', 'coupon_number', 'order', 'order_status', 'breadcrumbs', 'goBack'));
    }

    public function printOrder($checkout_code)
    {
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->printOrderConvert($checkout_code));
        return $pdf->stream();
    }

    public function printOrderConvert($checkout_code)
    {
        $Order_detail = OrderDetail::where('order_code', $checkout_code)->get();
        $order = Order::where('order_code', $checkout_code)->get();
        foreach ($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }
        $customer = User::where('id', $customer_id)->first();
        $shipping = Shipping::where('id', $shipping_id)->first();

        $Order_detail_product = OrderDetail::with('product')->where('order_code', $checkout_code)->get();

        foreach ($Order_detail_product as $key => $order_d) {

            $product_coupon = $order_d->product_coupon;
        }
        if ($product_coupon != 'no') {
            $coupon = Coupon::where('code', $product_coupon)->first();

            $coupon_condition = $coupon->condition;
            $coupon_number = $coupon->number;

            if ($coupon_condition == 1) {
                $coupon_echo = $coupon_number . '%';
            } elseif ($coupon_condition == 2) {
                $coupon_echo = number_format($coupon_number, 0, ',', '.') . 'đ';
            }
        } else {
            $coupon_condition = 2;
            $coupon_number = 0;

            $coupon_echo = '0';
        }

        $output = '';

        $output .= '
                <style>body{
                    font-family: DejaVu Sans;
                    charset=utf-8;
                }
                .table-styling{
                    border:1px solid #000;
                }
                .table-styling tbody tr td{
                    border:1px solid #000;
                }
                </style>
                <div id="wrapper" style="margin:0 auto;">
                <table width="100%">
                          <!--DWLayoutTable-->
                          <tr>
                            <td height="25" valign="top"align="center"><div align="left">
                        <table width="100%">
                          <tbody>
                            <tr>
                              <td width="5" height="95">&nbsp;</td>

                              <td width="343"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tbody>
                              <tr>
                                <td><table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tbody>
                                <tr>
                                  <td colspan="2"><h2 style="color:#009900;padding-left:190px;">Nhà Sách MâyBook.com</h2></td>
                                </tr>
                                <tr>
                                  <td style="padding-left:300px;"><i style="font-size:17px;">Address</i></td>
                                  <td> : Hoài Đức - Hà Nội</td>
                                </tr>
                                <tr>
                                <td style="padding-left:300px;"><i style="font-size:17px;">Phone </td>
                                  <td>: 0123456789</td>
                                </tr>
                                <tr>
                                <td style="padding-left:300px;"><i style="font-size:17px;">Email</td>
                                  <td>: danhha@gmail.com</td>
                                </tr>
                                    </tbody>
                                </table></td>
                              </tr>
                            </tbody>
                              </table></td>
                            </tr>
                          </tbody>
                        </table>
                            </div></td>
                          </tr>
                          <tr>
                            <td width="580" height="25" valign="top" align="center">  <hr>
                            <br>
                        <b style="color:#FF0000;font-size:25px;">Chi Tiết Đơn Hàng</b> <br>';

        $output .= '
                    <b style="font-size:16px;color:#0000CD">ID : ' . $checkout_code . '</b></td>

                    </tr>
                      <tr>
                        <td height="54"  >
                            <div align="left">
                        <b>Thông tin Khách hàng:</b></div><br>
                    <table width="100%" >';

        $output .= '<tr><td width="3%" >&nbsp;</td>
                        <td width="34%" >Name : </td><td width="63%"> ' . $shipping->name . '
                    </td></tr>';
        $output .= '<tr><td width="3%" >&nbsp;</td>
                    <td width="34%" >Address : </td><td width="63%"> ' . $shipping->address . '
                          </td></tr>';
        $output .= '<tr><td width="3%" >&nbsp;</td>
                    <td width="34%" >Phone number : </td><td width="63%"> ' . $shipping->phone . '
                    </td></tr>';
        $output .= '<tr><td width="3%" >&nbsp;</td>
                    <td width="34%" >Email : </td><td width="63%"> ' . $shipping->email . '
                    </td></tr>';
        $output .= '<tr><td width="3%" >&nbsp;</td>
                    <td width="34%" >Date : </td><td width="63%"> ' . $ord->order_date . '</td></tr>
                                            <tr><td >&nbsp;</td></tr></table>
                                          <span class="style3"><b>Thông tin về Đơn Hàng : </b> <br><br></span>
                                      <table width="95%" style="padding-right:30px;">
                          <tr>
                          <th width="25%" bgcolor="#CCCCCC"  align="left" style="border:1px solid black;"><div align="center">Tên hàng</th>
                          <th width="15%" bgcolor="#CCCCCC"  align="left" style="border:1px solid black;"><div align="center">Mã giảm</th>
                          <th width="10%" bgcolor="#CCCCCC"  align="left" style="border:1px solid black;"><div align="center">Số lượng</th>
                          <th width="25%" bgcolor="#CCCCCC"  align="left" style="border:1px solid black;"><div align="center">Giá sản phẩm</th>
                          <th width="25%" bgcolor="#CCCCCC"  align="left" style="border:1px solid black;"><div align="center">Thành tiền</th>
                          </tr>';

        $total = 0;
        foreach ($Order_detail_product as $key => $product) {

            $subtotal = $product->product_price * $product->product_sales_quantity;
            $total += $subtotal;

            if ($product->product_coupon != 'no') {
                $product_coupon = $product->product_coupon;
            } else {
                $product_coupon = 'không mã';
            }

            $output .= '
                        <tr>
                            <td align="center" style="border:1px solid black;">' . $product->product_name . '</td>
                            <td align="center"  style="border:1px solid black;">' . $product_coupon . '</td>
                            <td align="center"  style="border:1px solid black;">' . $product->product_sales_quantity . '</td>
                            <td align="center"  style="border:1px solid black;">' . number_format($product->product_price, 0, ',', '.') . 'đ' . '</td>
                            <td align="center" style="border:1px solid black;">' . number_format($subtotal, 0, ',', '.') . 'đ' . '</td>

                        </tr>';
        }

        if ($coupon_condition == 1) {
            $total_after_coupon = ($total * $coupon_number) / 100;
            $total_coupon = $total - $total_after_coupon;
        } else {
            $total_coupon = $total - $coupon_number;
        }

        $output .= '
                    <tr style="border:1px solid black;"><td></td><td></td><td></td>
                          <td colspan="3" align="left"><div align="right" style="padding-right:20px;">
                    <b>Tổng tiền : ' . number_format($total, 0, ',', '.') . 'đ' . '</b> <br>
                    <b>Khuyến mãi : ' . $coupon_echo . '</b> <br>
                          <b style="color:green;">Phí ship: ' . number_format($product->product_feeship, 0, ',', '.') . 'đ' . ' <br>
                            <b style="color:red;">Thanh toán : ' . number_format($total_coupon + $product->product_feeship, 0, ',', '.') . 'đ' . '</b></div></td>
                    </tr></table><br>

                    <table width="550" border="0" align="left">
                                <tr>
                                  <td><i style="padding-left:100px;">Ngày Giao :' . date("d/m/Y") . '</i><br> <i style="padding-left:100px;">Địa Chỉ :' . $shipping->address . '</i></td>
                                  <td><div><b style="padding-left:100px;"> Nhân viên Bán hàng</b> <br> <br>
                                  </div></td>
                                </tr>
                  </table>
    </div>
                    ';
        return $output;
    }

    public function updateOrderStatus(Request $Request)
    {
        $data = $Request->all();
        $order = Order::find($data['id']);
        $order->order_status = $data['values'];
        $order->save();

        if ($order->order_status == 2) {
            foreach ($data['order_product_id'] as $key => $id) {
                $product = Product::findOrFail($id);
                $product_quantity = $product->quantity;
                $product_sold = $product->product_sold;

                $warehouse = WareHouse::where('id', $product->ware_houses_id)->first();
                $warehouseQuantity = $warehouse->inventory;

                foreach ($data['order_weight'] as $key1 => $weight) {
                    foreach ($data['quantity'] as $key2 => $qty) {
                        if ($key == $key1 && $key == $key2) {
                            $pro_remain = $product_quantity - ($qty * $weight);
                            $ware_remain = $warehouseQuantity - ($qty * $weight);

                            $product->quantity = $pro_remain;
                            $warehouse->inventory = $ware_remain;
                            $product->product_sold = $product_sold + ($qty * $weight);
                            $product->save();
                            $warehouse->save();
                        }
                    }
                }
            }
            $orderDate = OrderDate::where('order_id',$data['id'])->first();
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $orderDate->delivery_date = now();
            $orderDate->update();

        } elseif ($order->order_status == 1) {
            foreach ($data['order_product_id'] as $key => $id) {
                $product = product::find($id);
                $warehouse = WareHouse::where('id', $product->ware_houses_id)->first();
                $warehouseQuantity = $warehouse->inventory;
                $product_quantity = $product->quantity;
                $product_sold = $product->product_sold;
                foreach ($data['order_weight'] as $key1 => $weight) {
                    foreach ($data['quantity'] as $key2 => $qty) {
                        if ($key == $key1 && $key == $key2) {
                            $pro_remain = $product_quantity + ($qty * $weight);
                            $ware_remain = $warehouseQuantity + ($qty * $weight);
                            $product->quantity = $pro_remain;
                            $warehouse->inventory = $ware_remain;
                            $product->product_sold = $product_sold - ($qty * $weight);
                            $product->save();
                            $warehouse->save();
                        }
                    }
                }
            }
            $orderDate = OrderDate::where('order_id', $data['id'])->first();
            $orderDate->delivery_date = '';
            $orderDate->update();
        }
    }
}
