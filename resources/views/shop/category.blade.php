@extends('layouts.shop')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <div class="bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 rounded-3xl p-10 text-white mb-10">

        <h1 class="text-4xl font-extrabold">{{ $category->name }}</h1>

        <p class="mt-3 text-blue-100">{{ $products->count() }} Products Available</p>

    </div>
    
    @if($products->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <a href="{{ route('product.show', $product) }}" class="bg-white rounded-2xl shadow hover:shadow-2xl transition duration-300 overflow-hidden group block">
            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-56 object-contain bg-gray-100 group-hover:scale-110 transition duration-500">
            <h3 class="font-bold">{{ $product->name }}</h3>
            <p class="text-xl font-bold text-orange-500">Rs {{ number_format($product->price) }}</p>
        </a>
        @endforeach
    </div>
    @else
        <p>No products in this category.</p>
    @endif
</div>
@endsection