<!DOCTYPE html>
<html>
<head><title>Edit Category</title></head>
<body>
<h2>Edit Category</h2>
<form action="{{ route('categories.update', $category->id) }}" method="POST">
    @csrf
    @method('PUT')
    
    <label>Name</label>
    <input type="text" name="name" value="{{ $category->name }}" required>
    <br><br>

    <button type="submit">Update Category</button>
</form>
</body>
</html>