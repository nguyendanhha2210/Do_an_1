@extends('layouts.sale.auth-layout')
@section('content')
    <register-component
        :form-login="{{ json_encode(route('sale.users.login')) }}"
        :form-url="{{ json_encode(route('sale.users.register')) }}"
    ></register-component>
@endsection
