@extends('layouts.admin.layout')
@section('content')
    <type-component :form-add="{{ json_encode(route('admin.type.create')) }}"
        :data="{{ json_encode([
    'urlDeleteAllData' => route('admin.type.deleteAll'),
    'urlGetData' => route('admin.type.getData'),
]) }}">
    </type-component>
@endsection
