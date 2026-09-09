<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Routing\Controller;

class StripeController extends Controller
{
    public function checkout(Request $request)
{
    $order = Order::findOrFail($request->order_id);

    $order->update([
        'payment_method' => 'card',
        'payment_status' => 'Pending',
    ]);

    Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = Session::create([

            'payment_method_types' => ['card'],

            'line_items' => [[

                'price_data' => [

                    // 'currency' => 'pkr',
                    'currency' => 'usd',

                    'product_data' => [

                        'name' => 'NovaCart Order #'.$order->id,

                    ],

                    // 'unit_amount' => $order->total_price * 100,
                    'unit_amount' => 500,

                ],

                'quantity' => 1,

            ]],

            'mode' => 'payment',
            'success_url' => url('/stripe/success?order='.$order->id),
            'cancel_url' => url('/stripe/cancel?order='.$order->id),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request)
{
    $order = Order::findOrFail($request->order);


    $order->update([
        'status' => 'confirmed',
        'payment_method' => 'card',
        'payment_status' => 'Paid'
    ]);

    foreach ($order->items as $item) {

        $product = \App\Models\Product::find($item->product_id);

        if ($product) {

            $product->stock -= $item->quantity;

            if ($product->stock < 0) {
                $product->stock = 0;
            }

            $product->save();
        }
    }

    session()->forget('cart');

    return redirect()->route('orders.my')
        ->with('success', 'Payment Successful!');
}

    public function cancel(Request $request)
{
    $order = Order::findOrFail($request->order);

    $order->update([
        'status' => 'cancelled',
        'payment_method' => 'card',
        'payment_status' => 'Failed',
    ]);

    return redirect()
        ->route('orders.my')
        ->with('error', 'Payment was cancelled.');
}
}