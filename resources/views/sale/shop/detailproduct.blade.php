@extends('layouts.sale.layout')
@section('content')
    <detail-product :product="{{ json_encode($product) }}"></detail-product>
@endsection
