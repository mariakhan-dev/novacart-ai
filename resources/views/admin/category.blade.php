@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">
    <h2 class="text-3xl font-bold mb-6">{{ $category->name }}</h2>
    
    @if($products->count() > 0)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
        <a href="{{ route('product.show', $product) }}" class="bg-white rounded-lg shadow p-4 hover:shadow-xl block">
            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-48 object-cover rounded mb-3">
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