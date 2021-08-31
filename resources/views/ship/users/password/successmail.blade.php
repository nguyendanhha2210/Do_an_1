@extends('layouts.admin.auth-layout')
@section('content')
    <success-email :form-login="{{ json_encode(route('admin.users.login')) }}"></success-email>
@endsection
