@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Edit</a>
                <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.destroy', $product) }}" method="POST">
    @csrf 
    @method('DELETE')
    <button type="button" onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')" 
            class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
        Delete
    </button>
</form>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            <div>
                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-96 object-contain rounded-lg border" onerror="this.src='https://via.placeholder.com/400'">
            </div>
            <div>
                <p class="text-sm text-gray-500">Category: {{ $product->category->name ?? 'No Category' }}</p>
                <p class="text-3xl font-bold text-orange-500 my-3">Rs {{ number_format($product->price) }}</p>
                <p class="text-gray-700"><b>Stock:</b> {{ $product->stock ?? 'N/A' }}</p>
                <p class="text-gray-700 mt-4">{{ $product->description }}</p>
            </div>
        </div>
    </div>
</div>
<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Are You Sure?',
        text: " You want to delete " +name + "!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
            
            Swal.fire(
                'Deleted!',
                name + ' Deleted',
                'success'
            )
        }
    })
}
</script>
@endsection