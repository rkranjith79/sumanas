@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Order Listing</h2>
        <hr />
        <div class="row">
            <div class="card card-primary mb-4 shadow-sm p-0">
                <div class="card-header">{{ __('My Orders') }}</div>

                <div class="card-body">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Quantity / Price</th>
                                <th>Total</th>
                                <th>Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>{{ $order->product->name }}</td>
                                    <td>{{ $order->quantity }} unit / {{ $order->price }}</td>
                                    <td>{{ $order->total_amount }}</td>
                                    <td class="text-uppercase">
                                        @if ($order->status == 'completed')
                                            <span class="text-success">
                                                {{ $order->status }}
                                            </span>
                                        @else
                                        <span class="text-warning">
                                            {{ $order->status }}
                                        </span>
                                        @endif
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
