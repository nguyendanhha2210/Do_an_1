@extends('layouts.admin.auth-layout')
@section('content')
    <section class="shopping-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    {{-- @dd($shippingData) --}}
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Address</th>
                                <th scope="col">Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($shippingData as $key => $abc)
                                    <td>{{ $abc['product_name'] }}</td>
                                    <td>{{ $abc['product_name'] }}</td>
                                    <td>{{ $abc['product_name'] }}</td>
                                    <td>{{ $abc['product_name'] }}</td>
                                    <td>{{ $abc['product_name'] }}</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection
