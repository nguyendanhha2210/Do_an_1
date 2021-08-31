@extends('layouts.sale.auth-layout')
@section('content')
    <login-component
        :form-url="{{ json_encode(route('sale.users.login')) }}"
        :form-register="{{ json_encode(route('sale.users.register')) }}"
        
        :forgot-password-url="{{ json_encode(route('sale.users.forgot')) }}"
        :message="{{ json_encode(isset($message) ? $message : '') }}"
        :old-email="{{ json_encode(isset($old_email) ? $old_email : '') }}"
        :old-password="{{ json_encode(isset($old_password) ? $old_password : '') }}"
    ></login-component>
@endsection
