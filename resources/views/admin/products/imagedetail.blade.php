@extends('layouts.admin.layout')
@section('content')
    <image-detail :data="{{ json_encode(isset($data) ? $data : '') }}"></image-detail>
@endsection
