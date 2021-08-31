@extends('layouts.sale.layout-navBuilder')
@section('content')
    <detail-product :product="{{ json_encode($product) }}"></detail-product>
@endsection
