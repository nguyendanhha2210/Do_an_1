@extends('layouts.admin.layout')
@section('content')
    <description-component 
    :form-add="{{ json_encode(route('admin.description.create')) }}"
    ></description-component>
@endsection
