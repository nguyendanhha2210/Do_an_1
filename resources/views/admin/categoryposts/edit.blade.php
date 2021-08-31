@extends('layouts.admin.layout')
@section('content')
    <category-post-edit 
        :category="{{ json_encode($category) }}"
    ></category-post-edit>
@endsection
