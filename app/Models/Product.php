<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Stripe\Price;
use Stripe\Stripe;
use Stripe\Product as StripeProduct;
use Stripe\Price as StripePrice;
class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'description',
    ];

    public function formattedPrice()
    {
        return '$' . number_format($this->price, 2);
    }

    public function syncWithStripe()
    {
        $this->updateStripe();
        
        return $this;
    }

    private function updateStripe()
    {
        $product = $this;
        try {
            // Set your Stripe API key
            \Stripe\Stripe::setApiKey(config('stripe.secret'));

            // Find the corresponding Stripe product
            
            $stripeProduct = !empty($product->stripe_product_id) ? StripeProduct::retrieve($product->stripe_product_id) : null;

            // Update Stripe product
            $productData = [             
                'name' => $product->name,
                'description' => $product->description,
            ];

            if(!empty($stripeProduct)) {
                $stripeProduct = StripeProduct::update($product->stripe_product_id, $productData);
            } else {
                $stripeProduct = StripeProduct::create($productData);
            }

        $product->stripe_product_id = $stripeProduct->id;
        $product->save();

        $this->updateStripePrice($product->stripe_product_id);
        } catch (\Exception $e) {
            Log::error('Failed to update Stripe product: ' . $e->getMessage());
        }
    }

    private function updateStripePrice($StripeProductId)
    {
        $product = $this;
        try {
            // Set your Stripe API key
            \Stripe\Stripe::setApiKey(config('stripe.secret'));

            // Find the corresponding Stripe price
            $stripePrice = !empty($product->stripe_price_id) ? StripePrice::retrieve($product->stripe_price_id) : null;

            

            if(!empty($stripePrice)) {

                #update is not working   
                // $stripePrice->unit_amount = $product->price;
                // $stripePrice->currency = config('stripe.currency');
                // $stripePrice->save();

                #Insted of Update - New Id Generated
                $ProductData = [
                    'product' => $StripeProductId,   
                    'unit_amount' => $product->price * 100,
                    'currency' => config('stripe.currency'),
                ];
                
                $stripePrice = stripePrice::create($ProductData);
            
            } else {
                $ProductData = [
                    'product' => $StripeProductId,   
                    'unit_amount' => $product->price * 100,
                    'currency' => config('stripe.currency'),
                ];
                
                $stripePrice = stripePrice::create($ProductData);
            }
            
            $product->stripe_price_id = $stripePrice->id;
            $product->save();
        } catch (\Exception $e) {
            Log::error('Failed to update Stripe price: ' . $e->getMessage());
        }
    }
    
}
