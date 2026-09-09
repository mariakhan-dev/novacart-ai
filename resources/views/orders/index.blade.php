@extends('layouts.shop')

@section('content')

<div class="max-w-7xl mx-auto px-6 py-10">

    <h1 class="text-4xl font-bold mb-8">
        📦 My Orders
    </h1>

    @forelse($orders as $order)

    <div class="bg-white rounded-3xl shadow-lg p-8 mb-8">

        <div class="flex justify-between items-center border-b pb-5 mb-5">

            <div>
                <h2 class="text-2xl font-bold">
                    Order #{{ $order->id }}
                </h2>

                <p class="text-gray-500">
                    {{ $order->created_at->format('d M Y • h:i A') }}
                </p>
            </div>

            <div>

    @if($order->status == "pending")

        <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full font-semibold">
            Pending
        </span>

    @elseif($order->status == "confirmed")

        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold">
            Confirmed
        </span>

    @elseif($order->status == "shipped")

        <span class="bg-blue-100 text-blue-700 px-4 py-2 rounded-full font-semibold">
            Shipped
        </span>

    @elseif($order->status == "delivered")

        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full font-semibold">
            Delivered
        </span>

    @elseif($order->status == "cancelled")

        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full font-semibold">
            Cancelled
        </span>

    @else

        <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-full font-semibold">
            {{ ucfirst($order->status) }}
        </span>

    @endif

    <div class="mt-3 text-sm text-gray-500">

    Payment:
    <span class="font-semibold text-gray-700">
        {{ strtoupper($order->payment_method) }}
    </span>

    —

    <span class="font-semibold
        {{ $order->payment_status == 'Paid'
            ? 'text-green-600'
            : 'text-yellow-600' }}">

        {{ $order->payment_status }}

    </span>

</div>

</div>

        </div>

        @foreach($order->items as $item)

        <div class="flex justify-between border-b py-3">

            <div>
                <h3 class="font-bold">
                    {{ $item->product_name }}
                </h3>

                <p class="text-gray-500">
                    Qty : {{ $item->quantity }}
                </p>
            </div>

            <div class="font-bold">
                Rs {{ number_format($item->price * $item->quantity) }}
            </div>

        </div>

        @endforeach

        <div class="flex justify-end mt-5">

            <h3 class="text-2xl font-bold text-orange-500">
                Total : Rs {{ number_format($order->total_price) }}
            </h3>

        </div>

    </div>

    @empty

    <div class="bg-white rounded-3xl shadow p-16 text-center">

        <h2 class="text-3xl font-bold mb-4">
            No Orders Yet
        </h2>

        <p class="text-gray-500 mb-6">
            Start shopping to see your orders here.
        </p>

        <a href="{{ route('shop') }}"
           class="bg-orange-500 text-white px-8 py-3 rounded-xl font-bold">

            Continue Shopping

        </a>

    </div>

    @endforelse

</div>

@endsection