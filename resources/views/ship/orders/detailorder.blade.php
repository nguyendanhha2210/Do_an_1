@extends('layouts.admin.layout')
@section('content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin đăng nhập
            </div>
            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light text-center">
                    <thead>
                        <tr>
                            <th>Tên khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin vận chuyển hàng
            </div>
            <div class="table-responsive">
                <?php
                $message = Session::get('message');
                if ($message) {
                    echo '<span class="text-alert">' . $message . '</span>';
                    Session::put('message', null);
                }
                ?>
                <table class="table table-striped b-t b-light text-center">
                    <thead>
                        <tr>

                            <th>Tên người vận chuyển</th>
                            <th>Địa chỉ</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Ghi chú</th>
                            <th>Hình thức thanh toán</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $shipping->name }}</td>
                            <td>{{ $shipping->address }}</td>
                            <td>{{ $shipping->phone }}</td>
                            <td>{{ $shipping->email }}</td>
                            <td>{{ $shipping->shipping_notes }}</td>
                            <td>
                            @if ($shipping->shipping_method == 0) Chuyển khoản @else
                                    Tiền mặt @endif
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <br><br>

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê chi tiết đơn hàng
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light text-center">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng kho còn</th>
                            <th>Mã giảm giá</th>
                            <th>Phí ship hàng</th>
                            <th>Số lượng</th>
                            <th>Giá sản phẩm</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                            $total = 0;
                        @endphp
                        @foreach ($order_details as $key => $details)

                            @php
                                $i++;
                                $subtotal = $details->product_price * $details->product_sales_quantity;
                                $total += $subtotal;
                            @endphp
                            <tr class="color_qty_{{ $details->product_id }}">

                                <td><i>{{ $i }}</i></td>
                                <td>{{ $details->product_name }}</td>
                                <td>{{ $details->product->quantity }}</td>
                                <td>
                                    @if ($details->product_coupon != 'no')
                                        {{ $details->product_coupon }}
                                    @else
                                        Không mã
                                    @endif
                                </td>
                                <td>{{ number_format($details->product_feeship, 0, ',', '.') }}đ</td>
                                <td>

                                    <input type="number" min="1" style="text-align: center;border:none" readonly
                                        {{ $order_status == 2 ? 'disabled' : '' }}
                                        class="order_qty_{{ $details->product_id }}"
                                        value="{{ $details->product_sales_quantity }}" name="product_sales_quantity">

                                    <input type="hidden" name="order_qty_storage"
                                        class="order_qty_storage_{{ $details->product_id }}"
                                        value="{{ $details->product->quantity }}">

                                    <input type="hidden" name="order_code" class="order_code"
                                        value="{{ $details->order_code }}">

                                    <input type="hidden" name="order_product_id" class="order_product_id"
                                        value="{{ $details->product_id }}">
                                </td>
                                <td>{{ number_format($details->product_price, 0, ',', '.') }}đ</td>
                                <td>{{ number_format($subtotal, 0, ',', '.') }}đ</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="12">
                                @php
                                    $total_coupon = 0;
                                @endphp
                                @if ($coupon_condition == 1)
                                    @php
                                        $total_after_coupon = ($total * $coupon_number) / 100;
                                        echo 'Tổng giảm :' . number_format($total_after_coupon, 0, ',', '.') . '</br>';
                                        $total_coupon = $total + $details->product_feeship - $total_after_coupon;
                                    @endphp
                                @else
                                    @php
                                        echo 'Tổng giảm :' . number_format($coupon_number, 0, ',', '.') . 'k' . '</br>';
                                        $total_coupon = $total + $details->product_feeship - $coupon_number;
                                        
                                    @endphp
                                @endif

                                Phí ship : {{ number_format($details->product_feeship, 0, ',', '.') }}đ</br>
                                Thanh toán: {{ number_format($total_coupon, 0, ',', '.') }}đ
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <form>
                @csrf
            </form>
            <div class="row w3-res-tb mb-1">
                <div for="paginate" class="col-md-4 col-sm-2 col-6 input-confirm">
                    <select data-order_id="{{ $order_id }}" class="form-control w-sm inline v-middle order_status">
                        @if ($order_status == 1)
                            <option value="1">Chưa xử lý</option>
                            <option value="2">Đang giao giao hàng</option>
                        @elseif($order_status==2)
                            <option value="2">Đang giao giao hàng</option>
                            <option value="1">Chưa xử lý</option>
                        @endif
                    </select>
                </div>
                <div class="col-sm-5 col-1" style="float: left"></div>
                <div class="col-md-3 col-sm-3 col-5">
                    <a class="btn btn-success" style="float: right" target="_blank"
                        href="{{ url('admin/print-order/' . $details->order_code) }}">In đơn hàng</a>
                </div>
            </div>
        </div>
    </div>
@endsection
