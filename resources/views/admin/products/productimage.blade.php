@extends('layouts.admin.layout')
@section('content')
    <product-image
        {{-- 
        :forgot-password-url="{{ json_encode(route('admin.forgot')) }}"
        :message="{{ json_encode(isset($message) ? $message : '') }}"
        :old-email="{{ json_encode(isset($old_email) ? $old_email : '') }}"
        :old-password="{{ json_encode(isset($old_password) ? $old_password : '') }}" --}}
    ></product-image>
@endsection
