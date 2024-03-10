<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->whereIn('status', ['completed', 'cancelled'])->get();
        return view('order.index', compact('orders'));
    }
    
    public function store(Request $request, Product $product)
    {
        $user = Auth::user();
        $order = new Order();
        $order->user_id = $user->id;
        $order->product_id = $product->id;
        $order->total_amount = $this->getTotalAmount($product->price, $request->quantity);
        $order->quantity = (int) $request->quantity;
        $order->price = $product->price;
        $order->status = 'pending';
        $order->payment_method = 'stripe';
        $order->save();

        
        #Process payment using Laravel Cashier 
        return $order->user->checkout([$order->product->stripe_price_id => $order->quantity], [
            'success_url' => route('order.success', ['order' => $order->id]),
            'cancel_url' => route('order.cancel', ['order' => $order->id]),
            'metadata' => ['order_id' => $order->id],
        ]);
        
        #Process payment using Direct Stripe Method 
        // \Stripe\Stripe::setApiKey(config('stripe.STRIPE_SECRET'));
        
        // $lineItems[] = 
        //           [
        //               'price_data' => [
        //                   'currency'     => 'usd',
        //                   'product_data' => [
        //                       'name' => $order->product->name,
        //                   ],
        //                   'unit_amount'  => (int) $order->product->price,
        //               ],
        //               'quantity'   => $order->quantity,
        //           ];
        // $charge = Charge::create([
        //     'amount' => $order->total_amount, // Amount in cents
        //     'currency' => 'usd',
        //     'source' => $request->stripeToken,
        //     'description' => 'Charge for ' . $user->email,
        // ]);

      
        // $stripeSession = \Stripe\Checkout\Session::create([
        //     'line_items'  =>  $lineItems,
        //     'mode'        => 'payment',
        //     'success_url' => route('stripe.success'),
        //     'cancel_url'  => route('stripe.cancel'),
        // ]);

        // return redirect()->away($stripeSession->url);
    }

    private function getTotalAmount($price, $quantity) 
    {
        return $price * $quantity;
    }

    public function success(Order $order)
    {
        $order->status = 'completed';
        $order->save();
        return redirect()->route('order.index');
    }
    
    public function cancel(Order $order)
    {
        $order->status = 'cancelled';
        $order->save();
        return redirect()->route('order.index');

    }
}
