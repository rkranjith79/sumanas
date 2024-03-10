@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Product Listing - Admin</h2>
        <hr />
        <div class="row">
            <div class="card card-primary mb-4 shadow-sm p-0">
                <div class="card-header">{{ __('Products') }}
                    <a href="{{ route('products.create') }}" class="nav-link float-right text-primary">+ Add Product</a>
                </div>

                <div class="card-body">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>
                                        <a href="{{ route('products.edit', $product) }}"
                                            class="btn btn-sm btn-secondary">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
