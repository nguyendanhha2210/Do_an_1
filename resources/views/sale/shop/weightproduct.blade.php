@extends('layouts.sale.layout-navBuilder')
@section('content')
    <weight-product :product-weight="{{ json_encode($productWeight) }}"></weight-product>
@endsection