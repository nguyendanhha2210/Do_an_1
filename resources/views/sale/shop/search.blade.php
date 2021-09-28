@extends('layouts.sale.layout-navBuilder')
@section('content')
     <search-result :search-item="{{ json_encode($ab) }}"></search-result>
@endsection


