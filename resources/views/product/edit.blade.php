@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Product - Admin</h2>
        <hr />
        <div class="row">
            <div class="card card-primary mb-4 shadow-sm p-0">
                <div class="card-header">{{ __('Edit Product') }}
                <a class="nav-link float-right text-primary"  href="{{ route('products.index') }}">Back</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.update', $product) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="name">Name<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name') ?? $product->name }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="price">Price<span class="text-danger">*</span></label>
                            <input type="text" name="price" id="price" class="form-control"
                                value="{{ old('price') ?? $product->price }}">
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') ?? $product->description }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-secondary">Update Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
