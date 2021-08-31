@extends('layouts.sale.layout-navBuilder')
@section('content')
    <description-product :product-description="{{ json_encode($productDescription) }}"></description-product>
@endsection