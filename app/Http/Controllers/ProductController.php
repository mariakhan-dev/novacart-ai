<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Order;
use App\Models\User;
use Storage;
class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::with('category');

    // Search
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    // Sort
    switch ($request->sort) {
        case 'price_low':
            $query->orderBy('price', 'asc');
            break;

        case 'price_high':
            $query->orderBy('price', 'desc');
            break;

        case 'name_asc':
            $query->orderBy('name', 'asc');
            break;

        default:
            $query->latest();
            break;
    }

    // $products = $query->get();
    $products = $query->paginate(16)->withQueryString();
    $totalOrders = Order::count();

$totalRevenue = Order::where('payment_status', 'Paid')
    ->sum('total_price');

$pendingOrders = Order::where('status', 'pending')->count();

$lowStock = Product::where('stock', '<=', 5)
    ->count();

$totalUsers = User::count();
$recentOrders = Order::latest()->take(5)->get();

    return view('admin.products.index', compact(
    'products',
    'totalOrders',
    'totalRevenue',
    'pendingOrders',
    'lowStock',
    'totalUsers',
    'recentOrders'
));
}
    public function create()
    {
        $categories = Category::all(); // sari categories le aao
        return view('admin.products.create', compact('categories'));
    }
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'category_id' => 'required',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);
    $data = $request->all();
    if($request->hasFile('image')){
        $data['image']= $request->file('image')->store('products', 'public');
    }
    Product::create($data); // data save ho jayega
    return redirect()->route('admin.products.index')->with('success','Product added!');
}
public function show(Product $product)
{
    // Related products (same category)
    $related = Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->where('stock', '>', 0)
        ->take(4)
        ->get();

    // AI Recommendations (same category + similar price)
    $recommended = Product::where('id', '!=', $product->id)
        ->where('stock', '>', 0)
        ->where(function ($query) use ($product) {
            $query->where('category_id', $product->category_id)
                  ->orWhereBetween('price', [
                      $product->price - 3000,
                      $product->price + 3000
                  ]);
        })
        ->inRandomOrder()
        ->take(4)
        ->get();

    return view('shop.show', compact(
        'product',
        'related',
        'recommended'
    ));
}
    public function showAdmin(Product $product)
    {
        return view('admin.products.show', compact('product')); // naya view
    }
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }
public function update(Request $request, Product $product)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    ]);
    $data = $request->except('image');
    if($request->hasFile('image')){
             if($product->image){
            Storage::disk('public')->delete($product->image);
        }
             $data['image'] = $request->file('image')->store('products', 'public');
    }
    $product->update($data);
    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
}

    public function destroy(Product $product)
    {
        if($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product Deleted Successfully!');
    }
public function category(Category $category)
{
    $products = Product::where('category_id', $category->id)->latest()->get();
    return view('shop.category', compact('category', 'products'));
}
public function shop(Request $request)
{
    $query = Product::with('category');
    // 1. SEARCH
    if($request->filled('search')){
        $query->where('name', 'like', '%'.$request->search.'%');
    }
    // 2. SORT
    $sort = $request->sort;
    if($sort == 'price_low'){
        $query->orderBy('price', 'asc');
    } elseif($sort == 'price_high'){
        $query->orderBy('price', 'desc');
    } elseif($sort == 'name_asc'){
        $query->orderBy('name', 'asc');
    } else {
        $query->latest(); 
    }
    // $products = $query->get();
    $products = $query->paginate(16)->withQueryString();
$categories = Category::withCount('products')->get();

return view('shop.index', compact('products', 'categories'));
}
}
