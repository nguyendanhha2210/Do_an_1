@extends('layouts.admin.layout')
@section('content')
<weight-add
        :weight-add="{{ json_encode(route('admin.weight.create')) }}"
    ></weight-add>
@endsection
