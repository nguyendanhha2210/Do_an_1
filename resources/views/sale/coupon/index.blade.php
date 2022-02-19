@extends('layouts.sale.layout')
@section('content')
    <coupon-component :today="{{ json_encode(isset($today) ? $today : '') }}"></coupon-component>
@endsection
