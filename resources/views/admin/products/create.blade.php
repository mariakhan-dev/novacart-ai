@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <div class="bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 rounded-3xl p-8 mb-8 text-white shadow-2xl">

    <span class="bg-blue-600 px-4 py-2 rounded-full text-sm font-semibold">
        📦 Product Management
    </span>

    <h1 class="text-4xl font-bold mt-5">
        Add New Product
    </h1>

    <p class="text-slate-300 mt-3">
        Create a new product for your store with images, pricing and inventory.
    </p>

</div>

    <!-- ERROR SHOW -->
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-6">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-8 rounded-2xl shadow-lg">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- CATEGORY -->
            <div class="relative">
                <select name="category_id" required
                        class="peer w-full border-2 border-gray-200 rounded-xl px-4 pt-6 pb-2 focus:border-blue-500 focus:outline-none transition">
                    <option value=""></option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <label class="absolute left-4 top-2 text-sm text-gray-500 peer-focus:text-blue-500 transition">Category</label>
                <a href="{{ route('admin.categories.create') }}" class="text-xs text-blue-600 mt-1 inline-block">+ Add New Category</a>
            </div>

            <!-- PRODUCT NAME -->
            <div class="relative">
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="peer w-full border-2 border-gray-200 rounded-xl px-4 pt-6 pb-2 focus:border-blue-500 focus:outline-none transition">
                <label class="absolute left-4 top-2 text-sm text-gray-500 peer-focus:text-blue-500 transition">Product Name</label>
            </div>

            <!-- DESCRIPTION -->
            <div class="md:col-span-2 relative">
                <textarea name="description" rows="4" class="peer w-full border-2 border-gray-200 rounded-xl px-4 pt-6 pb-2 focus:border-blue-500 focus:outline-none transition">{{ old('description') }}</textarea>
                <label class="absolute left-4 top-2 text-sm text-gray-500 peer-focus:text-blue-500 transition">Description</label>
            </div>

            <!-- PRICE -->
            <div class="relative">
                <input type="number" name="price" step="0.01" value="{{ old('price') }}" required
                       class="peer w-full border-2 border-gray-200 rounded-xl px-4 pt-6 pb-2 focus:border-blue-500 focus:outline-none transition">
                <label class="absolute left-4 top-2 text-sm text-gray-500 peer-focus:text-blue-500 transition">Price Rs</label>
            </div>

            <!-- STOCK -->
            <div class="relative">
                <input type="number" name="stock" value="{{ old('stock') }}" required
                       class="peer w-full border-2 border-gray-200 rounded-xl px-4 pt-6 pb-2 focus:border-blue-500 focus:outline-none transition">
                <label class="absolute left-4 top-2 text-sm text-gray-500 peer-focus:text-blue-500 transition">Stock Quantity</label>
            </div>

            <!-- IMAGE UPLOAD -->
            <div class="border-2 border-dashed border-blue-300 rounded-2xl p-8 text-center hover:border-blue-500 transition">

    <img id="preview"
         class="mx-auto w-32 h-32 object-cover rounded-xl hidden mb-4">

    <label class="cursor-pointer">

        <span class="bg-blue-600 text-white px-5 py-3 rounded-xl">
            Choose Product Image
        </span>

        <input type="file"
               name="image"
               id="imageInput"
               class="hidden"
               accept="image/*">

    </label>

    <p class="text-gray-500 mt-3">
        JPG, PNG (Max 2MB)
    </p>

</div>
        </div>

        <!-- BUTTONS -->
        <div class="flex gap-4 mt-8 border-t pt-6">
            <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-xl hover:bg-green-700 font-semibold shadow-md hover:shadow-lg transition">
                Save Product
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
        preview.classList.remove('hidden');
    }
});
</script>
@endsection