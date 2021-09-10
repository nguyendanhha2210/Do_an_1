@extends('layouts.admin.layout')
@section('content')
    <description-component :form-add="{{ json_encode(route('admin.description.create')) }}"
        :data="{{ json_encode([
    'urlDeleteAllData' => route('admin.description.deleteAll'),
    'urlGetData' => route('admin.description.getData'),
]) }}">
    </description-component>
@endsection
