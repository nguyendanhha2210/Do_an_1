@extends('layouts.admin.layout')
@section('content')
    <coupon-component
    :add-send="{{ json_encode(route('admin.coupon.addForSendMail')) }}"
    :add-show="{{ json_encode(route('admin.coupon.addForShowCustomer')) }}"
    :today="{{ json_encode(isset($today) ? $today : '') }}"
    ></coupon-component>
@endsection
