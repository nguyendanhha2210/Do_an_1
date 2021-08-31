@extends('layouts.admin.auth-layout')
@section('content')
    <forgot-password 
        :form-url="{{ json_encode(route('admin.users.forgot')) }}"
        :form-login="{{ json_encode(route('admin.users.login')) }}"
        :message="{{ json_encode(isset($message) ? $message : '') }}"
        :message2="{{ json_encode(isset($message2) ? $message2 : '') }}"
        :old-email="{{ json_encode(isset($old_email) ? $old_email : '') }}">
    ></forgot-password>
@endsection
