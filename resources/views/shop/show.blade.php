@extends('layouts.shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <!-- Breadcrumb -->
<div class="mb-8 text-sm text-gray-500 flex items-center gap-2">

    <a href="{{ route('shop') }}"
       class="hover:text-blue-600">

        Home

    </a>

    <span>/</span>

    <a href="{{ route('category.show',$product->category) }}"
       class="hover:text-blue-600">

        {{ $product->category->name }}

    </a>

    <span>/</span>

    <span class="text-gray-800 font-semibold">

        {{ $product->name }}

    </span>

</div>
    
    <!-- PRODUCT DETAIL -->
<div class="bg-white rounded-3xl shadow-2xl overflow-hidden grid lg:grid-cols-2 gap-0">
        
        <!-- LEFT: IMAGE -->
        <!-- Product Image -->

<div class="bg-gray-100 p-10 flex items-center justify-center">

    <img

        src="{{ asset('storage/'.$product->image) }}"

        class="max-h-[500px] object-contain transition duration-500 hover:scale-110"

    >

</div>

        <!-- RIGHT: DETAILS -->
       <div class="p-10 flex flex-col justify-center">
            <div class="flex gap-3 mb-4">

    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">

        {{ $product->category->name }}

    </span>

   @if($product->stock > 0)

    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
        In Stock
    </span>

    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
        {{ $product->stock }} available
    </span>

@else

    <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
        Out of Stock
    </span>

@endif

</div>
            <h1 class="text-3xl font-bold mt-1">{{ $product->name }}</h1>
            
            <!-- Product Name -->

<h1 class="text-4xl font-extrabold text-slate-900 leading-tight">

    {{ $product->name }}

</h1>

<!-- Rating -->

<div class="flex items-center gap-3 mt-4">

    <div class="text-yellow-400 text-xl">

        ⭐⭐⭐⭐⭐

    </div>

    <span class="text-gray-500">

        (4.9 • 125 Reviews)

    </span>

</div>

<!-- Price -->

<div class="mt-8">

    <span class="text-5xl font-black text-orange-500">

        Rs {{ number_format($product->price) }}

    </span>

</div>

<!-- Description -->

<div class="mt-8 leading-8 text-gray-600">

    {{ $product->description }}

</div>

<!-- Quantity -->

@if($product->stock > 0)

<form action="{{ route('cart.store',$product) }}" method="POST" class="mt-10">
    @csrf

    <div class="flex gap-5 items-center">

        <input
            type="number"
            name="quantity"
            value="1"
            min="1"
            max="{{ $product->stock }}"
            class="w-24 rounded-xl border-2 border-gray-200 text-center py-3 font-bold text-lg">

        <button
            class="flex-1 bg-orange-500 hover:bg-orange-600 text-white rounded-xl py-4 text-lg font-bold">
            🛒 Add To Cart
        </button>

    </div>
</form>

@else

<div class="mt-10 bg-red-100 text-red-700 text-center py-4 rounded-xl font-bold">
    ❌ This product is currently out of stock.
</div>

@endif

<!-- Buy Now -->

<a

href="{{ route('cart.checkout') }}"

class="mt-5 block text-center bg-slate-900 hover:bg-black text-white py-4 rounded-xl text-lg font-bold transition">

⚡ Buy Now

</a>
        </div>
    </div>

    @if($recommended->count())

<section class="mt-20">

    <div class="flex justify-between items-center mb-8">

        <div>

            <span class="bg-gradient-to-r from-purple-600 to-blue-600 text-white px-4 py-2 rounded-full text-sm font-semibold">
                🤖 AI Powered
            </span>

            <h2 class="text-3xl font-bold mt-4">
                NovaCart AI Recommends
            </h2>

            <p class="text-gray-500">
                Products selected using category, price and availability.
            </p>

        </div>

    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach($recommended as $item)

        <div class="bg-white rounded-2xl shadow hover:shadow-2xl transition duration-300 overflow-hidden group">

            <a href="{{ route('product.show',$item) }}">

                <div class="overflow-hidden bg-gray-100">

                    <img src="{{ asset('storage/'.$item->image) }}"
                         class="w-full h-56 object-contain group-hover:scale-110 transition duration-500">

                </div>

                <div class="p-5">

                    <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full">
                        AI Pick
                    </span>

                    <h3 class="font-bold text-lg mt-3 line-clamp-2">
                        {{ $item->name }}
                    </h3>

                    <p class="text-orange-500 text-2xl font-bold mt-3">
                        Rs {{ number_format($item->price) }}
                    </p>

                </div>

            </a>

        </div>

        @endforeach

    </div>

</section>

@endif

    <!-- RELATED PRODUCTS -->
@if($related->count())

<section class="mt-20">

    <div class="flex justify-between items-center mb-8">

        <div>

            <h2 class="text-3xl font-bold">

                You May Also Like

            </h2>

            <p class="text-gray-500">

                Similar products selected for you

            </p>

        </div>

    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach($related as $item)

        <div class="bg-white rounded-2xl shadow hover:shadow-2xl transition duration-300 overflow-hidden group">

            <a href="{{ route('product.show',$item) }}">

                <div class="overflow-hidden bg-gray-100">

                    <img

                    src="{{ asset('storage/'.$item->image) }}"

                    class="w-full h-56 object-contain group-hover:scale-110 transition duration-500">

                </div>

                <div class="p-5">

                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">

                        {{ $item->category->name }}

                    </span>

                    <h3 class="font-bold text-lg mt-3 line-clamp-2">

                        {{ $item->name }}

                    </h3>

                    <p class="text-orange-500 text-2xl font-bold mt-3">

                        Rs {{ number_format($item->price) }}

                    </p>

                </div>

            </a>

        </div>

        @endforeach

    </div>

</section>

@endif

</div>
@endsection`