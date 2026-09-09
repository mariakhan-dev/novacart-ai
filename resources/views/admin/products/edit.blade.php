@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Edit Product</h2>
    </div>
    @if($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-8 rounded-2xl shadow-lg">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- CATEGORY -->
            <div class="relative">
                <select name="category_id" required
                        class="peer w-full border-2 border-gray-200 rounded-xl px-4 pt-6 pb-2 focus:border-blue-500 focus:outline-none transition">
                    <option value=""></option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected($product->category_id == $cat->id)>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <label class="absolute left-4 top-2 text-sm text-gray-500 peer-focus:text-blue-500 transition">Category</label>
            </div>

            <!-- PRODUCT NAME -->
            <div class="relative">
                <input type="text" name="name" value="{{ $product->name }}" required
                       class="peer w-full border-2 border-gray-200 rounded-xl px-4 pt-6 pb-2 focus:border-blue-500 focus:outline-none transition">
                <label class="absolute left-4 top-2 text-sm text-gray-500 peer-focus:text-blue-500 transition">Product Name</label>
            </div>

            <!-- DESCRIPTION -->
            <div class="md:col-span-2 relative">
                <textarea name="description" rows="4"
                          class="peer w-full border-2 border-gray-200 rounded-xl px-4 pt-6 pb-2 focus:border-blue-500 focus:outline-none transition">{{ $product->description }}</textarea>
                <label class="absolute left-4 top-2 text-sm text-gray-500 peer-focus:text-blue-500 transition">Description</label>
            </div>

            <!-- PRICE -->
            <div class="relative">
                <input type="number" name="price" step="0.01" value="{{ $product->price }}" required
                       class="peer w-full border-2 border-gray-200 rounded-xl px-4 pt-6 pb-2 focus:border-blue-500 focus:outline-none transition">
                <label class="absolute left-4 top-2 text-sm text-gray-500 peer-focus:text-blue-500 transition">Price Rs</label>
            </div>

            <!-- STOCK -->
            <div class="relative">
                <input type="number" name="stock" value="{{ $product->stock }}" required
                       class="peer w-full border-2 border-gray-200 rounded-xl px-4 pt-6 pb-2 focus:border-blue-500 focus:outline-none transition">
                <label class="absolute left-4 top-2 text-sm text-gray-500 peer-focus:text-blue-500 transition">Stock Quantity</label>
            </div>

            <!-- IMAGE UPLOAD -->
            <div class="md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Product Image</label>

                <div class="flex items-center gap-6">
                    <img id="preview" src="{{ $product->image? asset('storage/'. $product->image) : 'https://via.placeholder.com/100' }}"
                         class="w-24 h-24 object-cover rounded-xl border-2 border-gray-200">

                    <label class="cursor-pointer">
                        <span class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 font-semibold">Change Image</span>
                        <input type="file" name="image" id="imageInput" class="hidden">
                    </label>
                </div>
                <p class="text-xs text-gray-400 mt-2">Leave empty to keep current image</p>
            </div>
        </div>

        <!-- BUTTONS -->
        <div class="flex gap-4 mt-8 border-t pt-6">
            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-xl hover:bg-blue-700 font-semibold shadow-md hover:shadow-lg transition">
                Update Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-100 text-gray-800 px-8 py-3 rounded-xl hover:bg-gray-200 font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
// LIVE IMAGE PREVIEW
document.getElementById('imageInput').addEventListener('change', function(e){
    const preview = document.getElementById('preview');
    const file = e.target.files[0];
    if(file){
        preview.src = URL.createObjectURL(file);
    }
});
</script>
@endsection