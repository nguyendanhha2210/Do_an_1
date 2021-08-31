@extends('layouts.admin.layout')
@section('content')
    <description-edit 
        :description="{{ json_encode($description) }}"
    ></description-edit>
@endsection
