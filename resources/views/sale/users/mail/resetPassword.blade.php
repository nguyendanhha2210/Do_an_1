@extends('layouts.sale.auth-layout')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Hi,Your reset password request has been received. <br> The path is
                        limited to one day. <br> Please click the
                        below link to change your password.</div>
                    <div class="card-body">
                        <a href="{{url('/sale/reset-password/'.$email.'/'.$token)}}">Click Here</a>.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
