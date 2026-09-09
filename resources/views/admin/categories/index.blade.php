@extends('layouts.admin')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800">Manage Categories</h2>
        <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-lg hover:bg-blue-700 font-semibold shadow">
            + Add Category
        </a>
    </div>

    @if(session('success')) 
        <p class="bg-green-100 text-green-700 p-3 rounded-lg mb-6">{{ session('success') }}</p> 
    @endif

    <!-- INLINE EDIT FORM - SIRF TAB SHOW HOGA JAB $editCategory SET HO -->
    @if(isset($editCategory))
    <div class="bg-white p-6 rounded-xl shadow-md mb-6 border-l-4 border-blue-500">
        <h3 class="text-xl font-bold mb-4">Edit Category: {{ $editCategory->name }}</h3>
        <form action="{{ route('categories.update', $editCategory->id) }}" method="POST" class="flex gap-3">
            @csrf
            @method('PUT')
            <input type="text" name="name" value="{{ $editCategory->name }}" required 
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold">Update</button>
            <a href="{{ route('categories.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-400 font-semibold">Cancel</a>
        </form>
    </div>
    @endif

    <!-- CATEGORIES TABLE -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="text-left py-3 px-6 font-semibold text-gray-600">ID</th>
                    <th class="text-left py-3 px-6 font-semibold text-gray-600">Category Name</th>
                    <th class="text-center py-3 px-6 font-semibold text-gray-600">Products</th>
                    <th class="text-center py-3 px-6 font-semibold text-grey-600">+ Product</th>
                    <th class="text-right py-3 px-6 font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4 px-6 text-gray-500">#{{ $category->id }}</td>
                    <td class="py-4 px-6 font-bold text-gray-800">{{ $category->name }}</td>
                    <td class="py-4 px-6 text-center">
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $category->products_count }} Products
                        </span>
                    </td>
                     <td>
                <a href="{{ route('admin.products.create', ['category_id' => $category->id]) }}" 
                   class="flex-1 bg-green-600 text-white px-3 py-2.5 rounded-xl text-sm hover:from-emerald-600 hover:to-green-600 font-bold shadow-md hover:shadow-lg flex items-center justify-center gap-1.5 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Product
                </a>
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex justify-end gap-3">
                            <!-- EDIT BUTTON AB INDEX PE HI BHEJE GA -->
                            <a href="{{ route('admin.categories.edit', $category) }}" class="bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-sm hover:bg-yellow-600">Edit</a>
                            
                            <!-- DELETE BUTTON CLASS CHANGE -->
                            <button onclick="confirmDelete({{ $category->id }}, '{{ $category->name }}')" 
                                    class="bg-red-500 text-white px-3 py-1.5 rounded-lg text-sm hover:bg-red-600">
                                Delete
                            </button>
                            <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="hidden">
                                @csrf @method('DELETE')
                            </form>
                        </div>
                    </td>
                   
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-10 text-gray-500">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- SWEETALERT2 FOR BEAUTIFUL ALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Delete category: " + name + "?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
@endsection