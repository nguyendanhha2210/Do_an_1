@extends('layouts.admin.layout')
@section('content')
    <type-edit 
        :type="{{ json_encode($type) }}"
    ></type-edit>
@endsection
