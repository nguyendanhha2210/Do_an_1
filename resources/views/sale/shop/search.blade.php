@extends('layouts.sale.layout-navBuilder')
@section('content')
     <search-result :search-item="{{ json_encode($resultSearch) }}"></search-result>
@endsection


