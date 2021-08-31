@extends('layouts.admin.layout')
@section('content')
    <coupon-edit 
        :coupon="{{ json_encode($coupon) }}"
    ></coupon-edit>
@endsection
