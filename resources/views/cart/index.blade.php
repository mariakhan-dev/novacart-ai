@extends('layouts.shop')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold mb-6">Your Shopping Cart</h1>

    @if(session('cart') && count(session('cart')) > 0)
    <div class="bg-white shadow rounded-lg p-6">
        <table class="w-full">
            <thead>
                <tr class="border-b">
                    <th class="text-left py-2">Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach(session('cart') as $id => $details)
                    @php $total += $details['price'] * $details['quantity'] @endphp
                    <tr class="border-b">
                        <td class="py-4 flex items-center gap-3">
                            <img src="{{ asset('storage/'.$details['image']) }}" class="w-16 h-16 object-cover rounded">
                            {{ $details['name'] }}
                        </td>
                        <td class="text-center">Rs {{ $details['price'] }}</td>
                        <td class="text-center">

    <div class="flex justify-center items-center gap-2">

        <a href="{{ route('cart.decrease',$id) }}"
           class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">

            -

        </a>

        <span class="font-bold">

            {{ $details['quantity'] }}

        </span>

        <a href="{{ route('cart.increase',$id) }}"
           class="bg-gray-200 px-3 py-1 rounded hover:bg-gray-300">

            +

        </a>

    </div>

</td>
                        <td class="text-center font-bold">Rs {{ $details['price'] * $details['quantity'] }}</td>
                        <td class="text-center">

<form action="{{ route('cart.remove',$id) }}" method="POST">

@csrf
@method('DELETE')

<button
class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded">

Remove

</button>

</form>

</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if(!empty(session('cart')))
<div class="bg-white p-6 rounded-xl shadow mt-6">
    <h3 class="text-xl font-bold mb-4">Checkout via WhatsApp</h3>
    
    <form action="{{ route('order.whatsapp') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <input type="text" name="name" placeholder="Your Name" required class="border rounded px-4 py-2">
            <input type="text" name="phone" placeholder="Your Phone" required class="border rounded px-4 py-2">
        </div>
        <textarea name="address" placeholder="Your Address" required rows="3" class="w-full border rounded px-4 py-2 mb-4"></textarea>
        
        <button type="submit" class="w-full bg-green-500 text-white py-3 rounded-lg font-bold hover:bg-green-600 flex items-center justify-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 4.315 1.731 6.086l-.884 3.236 3.336-.877z"/></svg>
            Order on WhatsApp
        </button>
    </form>
</div>
@endif
       @auth
<a href="{{ route('cart.checkout') }}"
   class="mt-4 inline-block bg-green-600 text-white px-6 py-3 rounded-xl hover:bg-green-700">
    Proceed to Checkout
</a>
@endauth

@guest
<a href="{{ route('login') }}"
   class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded-xl hover:bg-blue-700">
    Login to Checkout
</a>
@endguest
    </div>
    @else
    <p class="text-center text-gray-500">Your cart is empty!</p>
    @endif
</div>
@endsection