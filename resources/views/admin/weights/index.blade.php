@extends('layouts.admin.layout')
@section('content')
    <weight-component
        :form-add="{{ json_encode(route('admin.weight.create')) }}"
        :get-weight="{{json_encode(route('admin.weight.getData'))}}"
    ></weight-component>
@endsection
