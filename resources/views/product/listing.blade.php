@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Product Listing</h2>
        <hr />
        <div class="row">
            @forelse ($products as $product)
                <div class="col-md-4">
                    <form action="{{ route('order.store.buynow', ['product' => $product->id]) }}" method="post"
                        id="payment-form-{{ $product->id }}">
                        <div class="card card-primary mb-4 shadow-sm p-0" style="height: 250px">
                            <div class="card-body card-primary">
                                <h3 class="card-title">{{ $product->name }}</h3>
                                <p class="card-text">{{ $product->description }}</p>
                                <h5 class="text-muted text-uppercase">
                                    {{ config('stripe.currency') ?? '' }}{{ $product->price }}</h5>
                                <div class="w-100">
                                    @csrf

                                    <input type="hidden" name="form_id" value="{{ $product->id }}">
                                </div>
                            </div>
                            <div class="card-footer">

                                <div class="btn-group w-100">
                                    <input type="number" class="form-control" min="1" max="10" name="quantity"
                                        id="quantity-{{ $product->id }}" value="1" required>
                                    <button type="submit" onclick_="handleFormSubmission({{ $product->id }})"
                                        class="btn btn-sm btn-secondary w-50">Buy Now</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @empty
             <h5>No Products Available :)</h5>
            @endforelse
        </div>
    </div>
@endsection
