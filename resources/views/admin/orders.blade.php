@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-bold mb-6">All Orders</h2>

    @if(session('success'))
        <div class="bg-green-100 border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($orders->isEmpty())
        <div class="bg-white p-8 rounded-xl shadow text-center text-gray-500">
            No orders yet.
        </div>
    @endif

    <div class="space-y-6">
        @foreach($orders as $order)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Order Header -->
            <div class="bg-gray-50 px-6 py-4 border-b flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-lg">Order #{{ $order->id }}</h3>
                    <p class="text-sm text-gray-600">{{ $order->created_at->format('d M, Y h:i A') }}</p>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
    {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' :
       ($order->status == 'confirmed' ? 'bg-green-100 text-green-800' :
       ($order->status == 'shipped' ? 'bg-blue-100 text-blue-800' :
       ($order->status == 'delivered' ? 'bg-emerald-100 text-emerald-800' :
       ($order->status == 'cancelled' ? 'bg-red-100 text-red-800' :
       'bg-gray-100 text-gray-800')))) }}">
    {{ ucfirst($order->status) }}
</span>
<div class="mt-2 text-sm">

    <span class="font-semibold">Payment:</span>

    @if($order->payment_method == 'stripe')
        <span class="text-blue-600 font-semibold">💳 Stripe</span>
    @elseif($order->payment_method == 'cod')
        <span class="text-orange-600 font-semibold">💵 Cash on Delivery</span>
    @else
        <span class="text-green-600 font-semibold">
            📱 {{ ucfirst($order->payment_method) }}
        </span>
    @endif

</div>

<div class="text-sm">

    <span class="font-semibold">Payment Status:</span>

    @if($order->payment_status == 'Paid')
        <span class="text-green-600 font-semibold">✓ Paid</span>
    @else
        <span class="text-yellow-600 font-semibold">
            {{ $order->payment_status }}
        </span>
    @endif

</div>
                    <p class="font-bold text-xl mt-1 text-blue-600">Rs. {{ number_format($order->total_price) }}</p>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="px-6 py-4 border-b">
                <p><span class="font-semibold">Name:</span> {{ $order->name }}</p>
                <p><span class="font-semibold">Phone:</span> {{ $order->phone }}</p>
                <p><span class="font-semibold">Address:</span> {{ $order->address }}</p>
            </div>

            <!-- Order Items -->
            <div class="px-6 py-4">
                <h4 class="font-semibold mb-3">Items:</h4>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b text-left text-gray-600">
                            <th class="pb-2">Product</th>
                            <th class="pb-2 text-center">Qty</th>
                            <th class="pb-2 text-right">Price</th>
                            <th class="pb-2 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr class="border-b last:border-0">
                            <td class="py-2">{{ $item->product_name }}</td>
                            <td class="py-2 text-center">{{ $item->quantity }}</td>
                            <td class="py-2 text-right">Rs. {{ number_format($item->price) }}</td>
                            <td class="py-2 text-right font-semibold">Rs. {{ number_format($item->price * $item->quantity) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Actions -->
            <div class="bg-gray-50 px-6 py-3 text-right">
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline">
                    @csrf
                    <select name="status" class="border rounded px-3 py-1 text-sm">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed"    {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmed
</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button class="bg-blue-600 text-white px-4 py-1 rounded text-sm ml-2 hover:bg-blue-700">Update</button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection