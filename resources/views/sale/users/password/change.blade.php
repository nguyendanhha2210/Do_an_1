@extends('layouts.sale.auth-layout')
@section('content')
    <change-password 
        :form-url="{{ json_encode(route('sale.users.resetPassword')) }}"
        :form-login="{{ json_encode(route('sale.users.login')) }}" 
        :form-forgot="{{ json_encode(route('sale.users.forgot')) }}"
        :message="{{ json_encode(isset($message) ? $message : '') }}"
        :message2="{{ json_encode(isset($message2) ? $message2 : '') }}"
        :token-url="{{ json_encode(isset($tokenUrl) ? $tokenUrl : '') }}">
    </change-password>
@endsection