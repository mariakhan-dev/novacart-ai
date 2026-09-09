<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function index()
{
    $categories = Category::withCount('products')->latest()->get(); 
    return view('admin.categories.index', compact('categories'));
}

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories'
        ]);

        Category::create($request->all());
        return redirect()->route('admin.categories.index')->with('success','Category added!');
    }

    public function edit(Category $category) // Route model binding
{
    $categories = Category::withCount('products')->latest()->get();
    $editCategory = $category; // Ye variable bhej rahe hain form ke liye
    return view('admin.categories.index', compact('categories', 'editCategory'));
}

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id
        ]);

        $category->update($request->all());
        return redirect()->route('admin.categories.index')->with('success','Category updated!');
    }

    public function destroy(Category $category)
    {
        // pehle check karo koi product to use nahi kar raha
        if($category->products()->count() > 0){
            return back()->with('error','Cannot delete. Products exist in this category.');
        }
        
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success','Category deleted!');
    }



}