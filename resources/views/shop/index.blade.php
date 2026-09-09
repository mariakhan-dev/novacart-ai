@extends('layouts.shop')

@section('content')
<div class="bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 text-white rounded-3xl overflow-hidden shadow-2xl mb-10">

    <div class="max-w-7xl mx-auto px-8 py-16">

        <div class="grid lg:grid-cols-2 gap-10 items-center">

            <div>

                <span class="bg-blue-600 px-4 py-2 rounded-full text-sm font-semibold">
                    🚀 Smart Shopping Powered by AI
                </span>

                <h1 class="text-5xl font-extrabold mt-6 leading-tight">
                  Discover Smart Shopping with
                  <span class="text-orange-400">NovaCart AI</span>
                </h1>

                <p class="text-gray-300 text-lg mt-6 leading-8">
                    Shop the latest electronics, fashion, accessories and much more.
                    Experience AI-powered shopping with premium products, exclusive deals and fast delivery.
                </p>

                <div class="flex flex-wrap gap-4 mt-8">

                    <a href="#products"
                       class="bg-orange-500 hover:bg-orange-600 px-8 py-3 rounded-xl font-semibold transition">
                        Shop Now
                    </a>

                    <a href="{{ route('cart.index') }}"
                       class="border border-white hover:bg-white hover:text-slate-900 px-8 py-3 rounded-xl font-semibold transition">
                        View Cart
                    </a>

                </div>

            </div>

           <div class="hidden lg:flex m-0">

                <img src="https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?w=800"
                     class="h-[420px] object-cover">

            </div>


        </div>

    </div>

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

<!-- SHOP BY CATEGORY -->

<section class="mb-16">

    <div class="flex justify-between items-center mb-8">

        <div>

            <h2 class="text-4xl font-bold p-2">
                Shop by Category
            </h2>

            <p class="text-gray-500 mt-2 p-3">
                Browse products by category.
            </p>

        </div>

    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">

        @foreach($categories as $category)

            <a href="{{ route('category.show',$category) }}">

                <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 p-6 text-center">

                    <div class="w-20 h-20 mx-auto rounded-full bg-blue-100 flex items-center justify-center text-4xl">

                        📦

                    </div>

                    <h3 class="text-xl font-bold mt-5">

                        {{ $category->name }}

                    </h3>

                    <p class="text-gray-500 mt-2">

                        {{ $category->products_count }} Products

                    </p>

                    <div class="mt-5">

                        <span class="text-blue-600 font-semibold">

                            Explore →

                        </span>

                    </div>

                </div>

            </a>

        @endforeach

    </div>

</section>

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

    <!-- Products Grid -->
    @if($products->isEmpty())
        <div class="text-center py-10 bg-white rounded-xl shadow">
            <p class="text-gray-500 text-lg">
                @if(request('search'))
                    No products found for "{{ request('search') }}"
                @else
                    No products available.
                @endif
            </p>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
<div id="product-{{ $product->id }}"
     class="bg-white rounded-3xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden group hover:-translate-y-2">

    <div class="relative">

        <a href="{{ route('product.show',$product) }}">

            <img
                src="{{ asset('storage/'.$product->image) }}"
                class="w-full h-60 object-cover transition duration-500 group-hover:scale-110"
                onerror="this.src='https://via.placeholder.com/400x400.png?text=No+Image'">

        </a>

        <div class="absolute top-3 left-3">

            <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full">

                {{ $product->category->name ?? 'Category' }}

            </span>

        </div>

        @auth
    @php
        $isFavorite = \App\Models\Favorite::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists();
    @endphp

    <form action="{{ route('favorite.toggle', $product) }}"
      method="POST"
      class="absolute top-3 right-3">
        @csrf

        <button type="submit"
            class="w-10 h-10 rounded-full bg-white shadow hover:bg-red-500 hover:text-white transition">

            {{ $isFavorite ? '❤️' : '🤍' }}

        </button>
    </form>
@else
    <a href="{{ route('login') }}"
       class="absolute top-3 right-3 w-10 h-10 rounded-full bg-white shadow flex items-center justify-center hover:bg-red-500 hover:text-white transition">

        🤍

    </a>
@endauth

    </div>

    <div class="p-5">

        <div class="flex justify-between items-center mb-3">

            @if($product->stock > 5)

    <span class="text-green-600 text-sm font-semibold">
        ● {{ $product->stock }} in stock
    </span>

@elseif($product->stock > 0)

    <span class="text-orange-500 text-sm font-semibold">
        ● Only {{ $product->stock }} left
    </span>

@else

    <span class="text-red-600 text-sm font-semibold">
        ● Out of Stock
    </span>

@endif

            <span class="text-yellow-500">

                ★★★★★

            </span>

        </div>

        <a href="{{ route('product.show',$product) }}">

            <h3 class="text-lg font-bold hover:text-blue-600 transition truncate">

                {{ $product->name }}

            </h3>

        </a>

        <p class="text-gray-500 text-sm mt-2 h-10 overflow-hidden">

            {{ Str::limit($product->description ?? 'Premium Quality Product.',60) }}

        </p>

        <div class="flex justify-between items-center mt-5">

            <div>

                <p class="text-2xl font-bold text-blue-600">

                    Rs {{ number_format($product->price) }}

                </p>

            </div>

        </div>

        <div class="grid grid-cols-2 gap-3 mt-6">

            <a
            href="{{ route('product.show',$product) }}"
            class="text-center border border-blue-600 text-blue-600 rounded-xl py-2 hover:bg-blue-600 hover:text-white transition">

                Details

            </a>

            <form
            action="{{ route('cart.store',$product) }}"
            method="POST">

                @csrf

                @if($product->stock > 0)

    <button
        class="w-full bg-orange-500 hover:bg-orange-600 text-white rounded-xl py-2 transition">
        Add
    </button>

@else

    <button
        type="button"
        disabled
        class="w-full bg-gray-300 text-gray-500 rounded-xl py-2 cursor-not-allowed">
        Out of Stock
    </button>

@endif

            </form>

        </div>

    </div>

</div>
            @endforeach
        </div>
        <div class="mt-10">
    {{ $products->links() }}
</div>
    @endif
    <!-- WHY CHOOSE US -->
<section class="mt-20">

    <div class="text-center mb-12">

        <h2 class="text-4xl font-bold">
            Why Shop With Us?
        </h2>

        <p class="text-gray-500 mt-3">
            A smarter, faster and safer shopping experience.
        </p>

    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">

        <div class="bg-white rounded-3xl shadow-lg p-8 text-center hover:-translate-y-2 transition">
            <div class="text-5xl mb-4">🚚</div>
            <h3 class="font-bold text-xl">Fast Delivery</h3>
            <p class="text-gray-500 mt-3">
                Quick delivery across Pakistan.
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-8 text-center hover:-translate-y-2 transition">
            <div class="text-5xl mb-4">🔒</div>
            <h3 class="font-bold text-xl">Secure Payments</h3>
            <p class="text-gray-500 mt-3">
                Your payments are completely secure.
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-8 text-center hover:-translate-y-2 transition">
            <div class="text-5xl mb-4">🤖</div>
            <h3 class="font-bold text-xl">AI Recommendation</h3>
            <p class="text-gray-500 mt-3">
                Smart suggestions based on your interests.
            </p>
        </div>

        <div class="bg-white rounded-3xl shadow-lg p-8 text-center hover:-translate-y-2 transition">
            <div class="text-5xl mb-4">⭐</div>
            <h3 class="font-bold text-xl">Quality Products</h3>
            <p class="text-gray-500 mt-3">
                Carefully selected premium products.
            </p>
        </div>

    </div>

</section>

<!-- AI SECTION -->

<!-- <section class="mt-20 bg-gradient-to-r from-blue-700 to-indigo-800 rounded-3xl p-12 text-white">

    <div class="grid lg:grid-cols-2 gap-10 items-center">

        <div>

            <h2 class="text-4xl font-bold">

                🤖 AI Shopping Assistant

            </h2>

            <p class="mt-5 text-blue-100 leading-8">

                Soon you'll be able to search naturally like:

            </p>

            <ul class="mt-6 space-y-3">

                <li>✔ Show me laptops under Rs.50,000</li>

                <li>✔ Best gaming accessories</li>

                <li>✔ Affordable mobile phones</li>

                <li>✔ Recommend products for students</li>

            </ul>

            <button class="mt-8 bg-orange-500 hover:bg-orange-600 px-8 py-3 rounded-xl font-semibold">

                Coming Soon

            </button>

        </div>

        <div class="text-center">

            <div class="text-8xl">

                🤖

            </div>

        </div>

    </div>

</section> -->

<!-- NEWSLETTER -->

<!-- <section class="mt-20 mb-10">

    <div class="bg-white rounded-3xl shadow-xl p-12 text-center">

        <h2 class="text-4xl font-bold">

            Stay Updated

        </h2>

        <p class="text-gray-500 mt-4">

            Subscribe to receive new arrivals and exclusive offers.

        </p>

        <form class="flex flex-col md:flex-row justify-center gap-4 mt-8 max-w-2xl mx-auto">

            <input
                type="email"
                placeholder="Enter your email"
                class="flex-1 border rounded-xl px-5 py-3">

            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 rounded-xl">

                Subscribe

            </button>

        </form>

    </div>

</section>

</div>
@endsection -->