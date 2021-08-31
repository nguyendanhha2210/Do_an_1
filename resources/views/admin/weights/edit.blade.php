@extends('layouts.admin.layout')
@section('content')
    <weight-edit :weight-update="{{ json_encode(route('admin.weight.update', $data->id)) }}"
        :data="{{ json_encode($data) }}"></weight-edit>
@endsection
