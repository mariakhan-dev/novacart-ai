@extends('layouts.shop')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold mb-8 text-center">Checkout</h2>

    <div class="bg-white rounded-2xl shadow-lg p-8">
        <form action="{{ route('cart.placeOrder') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block font-semibold mb-2">Full Name</label>
                <input type="text" name="name" required 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2">Phone Number</label>
                <input type="text" name="phone" required 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
            </div>

            <div class="mb-6">
                <label class="block font-semibold mb-2">Shipping Address</label>
                <textarea name="address" rows="4" required 
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
            </div>
            
            <div class="mb-6">
    <label class="block font-semibold mb-4">Payment Method</label>

    <div class="space-y-3">

        <label class="flex items-center p-4 border rounded-xl cursor-pointer hover:border-orange-500">

            <input type="radio"
                   name="payment_method"
                   value="cod"
                   checked
                   class="mr-3">

            <div>
                <p class="font-bold">💵 Cash on Delivery</p>
                <p class="text-sm text-gray-500">
                    Pay when your order arrives.
                </p>
            </div>

        </label>

        <label class="flex items-center p-4 border rounded-xl cursor-pointer hover:border-blue-500">

            <input type="radio"
                   name="payment_method"
                   value="stripe"
                   class="mr-3">

            <div>
                <p class="font-bold">💳 Stripe Card Payment</p>
                <p class="text-sm text-gray-500">
                    Secure online payment using Visa or Mastercard.
                </p>
            </div>

        </label>

    </div>
</div>
            <div class="border-t pt-6 mb-6">
                <div class="flex justify-between text-xl font-bold">
                    <span>Total:</span>
                    <span class="text-blue-600">Rs. {{ number_format($total) }}</span>
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-orange-500 text-white py-4 rounded-xl font-bold text-lg hover:bg-orange-600 transition">
                Place Order
            </button>
        </form>
    </div>
</div>
@endsection