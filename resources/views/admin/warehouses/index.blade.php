@extends('layouts.admin.layout')
@section('content')
    <warehouse-component 
        :form-add="{{ json_encode(route('admin.warehouse.create')) }}"
    ></warehouse-component>
@endsection

