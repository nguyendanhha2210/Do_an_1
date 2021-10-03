@extends('layouts.admin.layout')
@section('content')
    <product-component
        :form-add="{{ json_encode(route('admin.product.create')) }}"
        :form-url="{{ json_encode(route('admin.product.update')) }}"
    ></product-component>
@endsection
