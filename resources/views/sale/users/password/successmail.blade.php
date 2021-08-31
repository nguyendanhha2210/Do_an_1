@extends('layouts.sale.auth-layout')
@section('content')
    <success-email :form-login="{{ json_encode(route('sale.users.login')) }}"></success-email>
@endsection
