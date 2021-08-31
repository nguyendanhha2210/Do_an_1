@extends('layouts.sale.layout-navBuilder')
@section('content')
    <type-product :product-type="{{ json_encode($productType) }}"></type-product>
@endsection
