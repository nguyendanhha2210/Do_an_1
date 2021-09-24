@extends('layouts.sale.layout-navBuilder')
@section('content')
    <search-result :search-result="{{ json_encode($searchResult) }}"></search-result>
@endsection