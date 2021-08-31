@extends('layouts.admin.layout')
@section('content')
    <warehouse-edit 
        :warehouse="{{ json_encode($warehouse) }}"
    ></warehouse-edit>
@endsection
