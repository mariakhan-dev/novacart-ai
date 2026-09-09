@extends('layouts.admin')

@section('content')
   <!-- DASHBOARD HEADER -->

    <div class="bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 text-white rounded-3xl overflow-hidden shadow-2xl mb-10">

    <div class="max-w-7xl mx-auto px-8 py-16">

        <div class="grid lg:grid-cols-2 gap-10 items-center">

            <div>

                <span class="bg-blue-600 px-4 py-2 rounded-full text-sm font-semibold">
                    🚀 Smart Shopping Powered by AI
                </span>

                <h1 class="text-5xl font-extrabold mt-6 leading-tight">
                    Discover Amazing Products
                    <span class="text-orange-400">At Best Prices</span>
                </h1>

                <p class="text-gray-300 text-lg mt-6 leading-8">
                    Shop the latest electronics, fashion, accessories and much more.
                    Enjoy a smarter shopping experience with Ecommerce-AI.
                </p>

                <div class="flex gap-4">

            <a href="{{ route('admin.products.create') }}"
               class="bg-orange-500 hover:bg-orange-600 px-7 py-4 rounded-xl font-bold transition shadow-lg mt-3">

                ➕ Add Product

            </a>

            <a href="{{ route('shop') }}"
               class="border border-white hover:bg-white hover:text-slate-900 px-7 py-4 rounded-xl font-bold transition mt-3">

                🛍 View Shop

            </a>

        </div>

            </div>

            <div class="grid grid-cols-2 gap-5">

                <div class="grid grid-cols-2 gap-5">

    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 text-center">
        <h2 class="text-4xl font-bold">{{ $products->count() }}</h2>
        <p class="text-gray-300 mt-2">Products</p>
    </div>

    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 text-center">
        <h2 class="text-4xl font-bold">{{ $totalOrders }}</h2>
        <p class="text-gray-300 mt-2">Orders</p>
    </div>

    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 text-center">
        <h2 class="text-4xl font-bold">{{ $totalUsers }}</h2>
        <p class="text-gray-300 mt-2">Customers</p>
    </div>

    <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 text-center">
        <h2 class="text-4xl font-bold">
            Rs {{ number_format($totalRevenue) }}
        </h2>
        <p class="text-gray-300 mt-2">Revenue</p>
    </div>

</div>

            </div>

        </div>

    </div>

</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

    <div class="bg-yellow-50 border border-yellow-200 rounded-2xl p-6">
        <h3 class="text-xl font-bold text-yellow-800">
            ⏳ Pending Orders
        </h3>

        <p class="text-4xl font-extrabold text-yellow-600 mt-3">
            {{ $pendingOrders }}
        </p>
    </div>

    <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
        <h3 class="text-xl font-bold text-red-800">
            ⚠️ Low Stock Products
        </h3>

        <p class="text-4xl font-extrabold text-red-600 mt-3">
            {{ $lowStock }}
        </p>
    </div>

</div>
<!-- RECENT ORDERS -->
<div class="bg-white rounded-3xl shadow-lg p-6 mb-10">

    <div class="flex justify-between items-center mb-6">

        <div>
            <h2 class="text-2xl font-bold">
                📦 Recent Orders
            </h2>

            <p class="text-gray-500">
                Latest customer orders
            </p>
        </div>

        <a href="{{ route('admin.orders') }}"
           class="text-blue-600 font-semibold hover:text-blue-800">
            View All →
        </a>

    </div>

    @forelse($recentOrders as $order)

        <div class="flex flex-col md:flex-row md:items-center
                    justify-between border-b last:border-0
                    py-4 gap-3">

            <div>
                <h3 class="font-bold">
                    Order #{{ $order->id }}
                </h3>

                <p class="text-sm text-gray-500">
                    {{ $order->name }}
                    • {{ $order->created_at->format('d M Y, h:i A') }}
                </p>
            </div>

            <div class="flex items-center gap-5">

                <span class="font-bold text-orange-500">
                    Rs {{ number_format($order->total_price) }}
                </span>

                @if($order->status == 'pending')

                    <span class="bg-yellow-100 text-yellow-700
                                 px-3 py-1 rounded-full text-sm font-semibold">
                        Pending
                    </span>

                @elseif($order->status == 'confirmed')

                    <span class="bg-green-100 text-green-700
                                 px-3 py-1 rounded-full text-sm font-semibold">
                        Confirmed
                    </span>

                @elseif($order->status == 'shipped')

                    <span class="bg-blue-100 text-blue-700
                                 px-3 py-1 rounded-full text-sm font-semibold">
                        Shipped
                    </span>

                @elseif($order->status == 'delivered')

                    <span class="bg-emerald-100 text-emerald-700
                                 px-3 py-1 rounded-full text-sm font-semibold">
                        Delivered
                    </span>

                @else

                    <span class="bg-red-100 text-red-700
                                 px-3 py-1 rounded-full text-sm font-semibold">
                        Cancelled
                    </span>

                @endif

            </div>

        </div>

    @empty

        <p class="text-gray-500 text-center py-6">
            No orders yet.
        </p>

    @endforelse

</div>

<!-- SEARCH -->

<div class="bg-white rounded-2xl shadow-lg p-6 mb-10">

    <form action="{{ route('shop') }}" method="GET">

        <div class="grid lg:grid-cols-12 gap-4">

            <div class="lg:col-span-7">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="🔍 Search products..."
                    class="w-full border rounded-xl px-5 py-3 focus:ring-2 focus:ring-blue-500">

            </div>

            <div class="lg:col-span-3">

                <select
                    name="sort"
                    class="w-full border rounded-xl px-5 py-3">

                    <option value="">Sort Products</option>

                    <option value="latest" {{ request('sort')=='latest' ? 'selected':'' }}>
                        Latest
                    </option>

                    <option value="price_low" {{ request('sort')=='price_low' ? 'selected':'' }}>
                        Price Low → High
                    </option>

                    <option value="price_high" {{ request('sort')=='price_high' ? 'selected':'' }}>
                        Price High → Low
                    </option>

                    <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected':'' }}>
                        Name A-Z
                    </option>

                </select>

            </div>

            <div class="lg:col-span-2">

                <button
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-xl py-3 font-semibold">

                    Search

                </button>

            </div>

        </div>

    </form>

</div>


<div id="products">

    <div class="flex justify-between items-center mb-8">

        <div>

            <h2 class="text-4xl font-bold">
                Featured Products
            </h2>

            <p class="text-gray-500 mt-2">
                Explore our latest collection.
            </p>

        </div>

    </div>

    @if(session('success')) 
        <p class="bg-green-100 text-green-700 p-3 rounded-lg mb-6">{{ session('success') }}</p> 
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <div class="bg-white rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 group border border-gray-100">
            
            <div class="relative">
                <a href="{{ route('admin.products.show', $product) }}">
                    @if($product->image)
                       <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-60 object-cover transition duration-500 group-hover:scale-110">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-400">No Image</div>
                    @endif
                    <div class="absolute top-3 left-3">

@if($product->stock > 10)

<span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full">
    In Stock
</span>

@elseif($product->stock > 0)

<span class="bg-yellow-500 text-white text-xs px-3 py-1 rounded-full">
    Low Stock
</span>

@else

<span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full">
    Out of Stock
</span>

@endif

</div>
                </a>

                <!-- HOVER ACTIONS -->
                <div class="absolute top-2 right-2 flex gap-2 opacity-0 group-hover:opacity-100 transition">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-white p-2 rounded-full shadow hover:bg-blue-500 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </a>
                    
                    <!-- DELETE BUTTON CHANGE -->
                    <button onclick="confirmProductDelete({{ $product->id }}, '{{ $product->name }}')" 
                            class="bg-white p-2 rounded-full shadow hover:bg-red-500 hover:text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>

                    <!-- HIDDEN FORM -->
                    <form id="delete-product-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="hidden">
                        @csrf @method('DELETE')
                    </form>
                </div>
            </div>

            <div class="p-6">
                <span class="inline-block bg-blue-100 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $product->category->name }}</span>
                <a href="{{ route('admin.products.show', $product) }}">
                    <h3 class="font-bold text-xl mt-3 group-hover:text-blue-600 transition">{{ $product->name }}</h3>
                </a>
                <p class="text-3xl font-extrabold text-orange-500 mt-4">Rs {{ number_format($product->price) }}</p>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-10">
    {{ $products->links() }}
</div>


<!-- SWEETALERT2 - AGAR PEHLE NAHI LAGAYA TO YE BHI ADD KARO -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmProductDelete(id, name) {
    Swal.fire({
        title: 'Delete Product?',
        text: "You are about to delete: " + name,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-product-form-' + id).submit();
            Swal.fire(
                'Deleted!',
                'Product has been deleted.',
                'success'
            )
        }
    })
}
</script>
@endsection