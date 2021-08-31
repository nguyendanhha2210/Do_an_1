@extends('layouts.admin.layout')
@section('content')
    <category-post-component
    :form-add="{{ json_encode(route('admin.categorypost.create')) }}"
    ></category-post-component>
@endsection
