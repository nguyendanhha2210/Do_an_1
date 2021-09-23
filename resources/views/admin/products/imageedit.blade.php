@extends('layouts.admin.layout')
@section('content')
    <image-edit :data="{{ json_encode(isset($data) ? $data : '') }}"></image-edit>
@endsection
