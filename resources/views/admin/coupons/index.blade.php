@extends('layouts.admin.layout')
@section('content')
    <coupon-component
    :form-add="{{ json_encode(route('admin.coupon.create')) }}"
    ></coupon-component>
@endsection
