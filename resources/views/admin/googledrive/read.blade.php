@extends('layouts.admin.layout')
@section('content')
    <div class="row">
        <ul class="google-drive">
            @foreach ($contents as $value)
                <li>Name : {{ $value['name'] }}</li>
                <li>Path : {{ $value['path'] }}</li>
                <li>Basename : {{ $value['basename'] }}</li>
                <li>Mimetype : {{ $value['mimetype'] }}</li>
                <li>Type : {{ $value['type'] }}</li>
                <li>Mimetype : {{ $value['size'] }}</li>
                <li>Download file cách 1 : <a href="https://drive.google.com/file/d/{{ $value['path'] }}/view"
                        target="_blank">Tải</a></li>
                <li>Download file cách 2 : <a
                        href="{{ url('/admin/download_document', ['path' => $value['path'], 'name' => $value['name']]) }}">Tải</a>
                </li>
                <li>Delete : <a href="{{ url('/admin/delete_document', ['path' => $value['path']]) }}">Delete</a></li>
                <li><iframe src="https://drive.google.com/file/d/{{ $value['path'] }}/preview"
                        style="pointer-events: none" width="640" height="640"></iframe></iframe>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
