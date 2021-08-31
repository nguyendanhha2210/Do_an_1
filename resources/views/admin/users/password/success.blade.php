@extends('layouts.admin.auth-layout')
@section('content')
    <success-change :form-login="{{ json_encode(route('admin.users.login')) }}"></success-change>
@endsection
