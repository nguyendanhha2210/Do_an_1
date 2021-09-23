@extends('layouts.admin.layout')
@section('content')
    <image-add 
        :product-id="{{ json_encode(isset($productId) ? $productId : '') }}"
    ></image-add>
@endsection
