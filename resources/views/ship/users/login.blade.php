@extends('layouts.ship.auth-layout')
@section('content')
    <login-component
        :form-url="{{ json_encode(route('ship.users.login')) }}"
        {{-- :forgot-password-url="{{ json_encode(route('admin.users.forgot')) }}" --}}
        :message="{{ json_encode(isset($message) ? $message : '') }}"
        :old-email="{{ json_encode(isset($old_email) ? $old_email : '') }}"
        :old-password="{{ json_encode(isset($old_password) ? $old_password : '') }}"
    ></login-component>
@endsection
