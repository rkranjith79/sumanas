@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Add Product - Admin</h2>
        <hr />
        <div class="row">
            <div class="card card-primary mb-4 shadow-sm p-0">
                <div class="card-header">
                    {{ __('Add Product') }}
                    <a class="nav-link float-right text-primary"  href="{{ route('products.index') }}">Back</a>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="post">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">
                                Name
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name') }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="price">Price<span class="text-danger">*</span></label>
                            <input type="text" name="price" id="price" class="form-control"
                                value="{{ old('price') }}">
                            @error('price')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-secondary">Add Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
