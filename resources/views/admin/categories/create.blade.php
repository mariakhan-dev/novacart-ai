@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-10">
    <div class="flex items-center gap-3 mb-8">
        <a href="{{ route('admin.categories.index') }}" class="text-gray-500 hover:text-gray-800">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h2 class="text-3xl font-bold text-gray-800">Add New Category</h2>
    </div>

    <!-- ERROR -->
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-6">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.categories.store') }}" method="POST"
          class="bg-white p-8 rounded-2xl shadow-lg">
        @csrf
        
        <!-- CATEGORY NAME -->
        <div class="relative mb-6">
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="peer w-full border-2 border-gray-200 rounded-xl px-4 pt-6 pb-2 focus:border-blue-500 focus:outline-none transition">
            <label class="absolute left-4 top-2 text-sm text-gray-500 peer-focus:text-blue-500 transition">Category Name</label>
        </div>

        <!-- DESCRIPTION OPTIONAL -->
        <div class="relative mb-8">
            <textarea name="description" rows="3" class="peer w-full border-2 border-gray-200 rounded-xl px-4 pt-6 pb-2 focus:border-blue-500 focus:outline-none transition">{{ old('description') }}</textarea>
            <label class="absolute left-4 top-2 text-sm text-gray-500 peer-focus:text-blue-500 transition">Description - Optional</label>
        </div>

        <!-- BUTTONS -->
        <div class="flex gap-4 border-t pt-6">
            <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-xl hover:bg-green-700 font-semibold shadow-md hover:shadow-lg transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Save Category
            </button>
            <a href="{{ route('admin.categories.index') }}" class="bg-gray-100 text-gray-800 px-8 py-3 rounded-xl hover:bg-gray-200 font-semibold transition">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection