@extends('layouts.sale.auth-layout')
@section('content')
    <success-change :form-login="{{ json_encode(route('sale.users.login')) }}"></success-change>
@endsection
