@extends('layouts.admin.layout')
@section('content')
    <coupon-component
    :form-add="{{ json_encode(route('admin.coupon.create')) }}"
    :today="{{ json_encode(isset($today) ? $today : '') }}"
    ></coupon-component>
@endsection
