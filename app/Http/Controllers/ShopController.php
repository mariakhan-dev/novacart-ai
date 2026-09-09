<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Routing\Controller;

class ShopController extends Controller
{
    public function index()
    {
        $categories = Category::take(6)->get();
        $newProducts = Product::latest()->take(8)->get();
        return view('shop.home', compact('categories', 'newProducts'));
    }
    public function show($id)
{
    $product = Product::findOrFail($id);
    $related = Product::where('category_id', $product->category_id)->take(4)->get();
    return view('shop.show', compact('product', 'related'));
}

}