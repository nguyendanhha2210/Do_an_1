@extends('layouts.admin.layout')
@section('content')
    <type-component
    :form-add="{{ json_encode(route('admin.type.create')) }}"
    ></type-component>
@endsection
