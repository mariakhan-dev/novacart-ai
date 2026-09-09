<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CartController extends Controller
{
    // Cart Page dikhana
    public function index()
{
    $cart = session()->get('cart', []); // default khali array
    $total = 0;
    foreach($cart as $details){
        $total += $details['price'] * $details['quantity'];
    }
    return view('cart.index', compact('cart', 'total')); // sirf $cart bhejo
}

    // Add to Cart
    public function store(Request $request, Product $product)
{
    $cart = Session::get('cart', []);

    if(isset($cart[$product->id])) {
        $cart[$product->id]['quantity'] += 1;
    } else {
        // sirf tab add karo jab product valid ho
        if($product->name && $product->price){
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }
    }
    Session::put('cart', $cart);
    return back()->with('success', 'Product added to cart!');
}

    // Remove from Cart
    public function destroy(Request $request, $id) // $id aa raha hai
{
    $cart = Session::get('cart');
    if(isset($cart[$id])) {
        unset($cart[$id]);
        Session::put('cart', $cart);
    }
    return back()->with('success', 'Item removed!');
}

public function checkout()
{
    $cart = session()->get('cart', []);
    if(empty($cart)) return redirect()->route('admin.products.index');
    
    $total = 0;
    foreach($cart as $details){ $total += $details['price'] * $details['quantity']; }
    return view('cart.checkout', compact('cart', 'total'));
}



public function placeOrder(Request $request)
{
    $request->validate([
        'name' => 'required',
        'phone' => 'required',
        'address' => 'required',
        'payment_method' => 'required|in:cod,stripe'
    ]);

    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return back()->with('error', 'Cart is empty');
    }

    $total = 0;

    foreach ($cart as $details) {
        $total += $details['price'] * $details['quantity'];
    }

    $order = Order::create([
        'user_id' => Auth::id(),
        'name' => $request->name,
        'phone' => $request->phone,
        'address' => $request->address,
        'total_price' => $total,
        'status' => 'pending',
        'payment_method' => $request->payment_method,
        'payment_status' => 'Pending'
    ]);

    foreach ($cart as $product_id => $details) {

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product_id,
            'product_name' => $details['name'],
            'quantity' => $details['quantity'],
            'price' => $details['price'],
        ]);

    }

    // CASH ON DELIVERY
    if ($request->payment_method == 'cod') {

    foreach ($order->items as $item) {

        $product = Product::find($item->product_id);

        if ($product) {

            $product->stock -= $item->quantity;

            if ($product->stock < 0) {
                $product->stock = 0;
            }

            $product->save();
        }
    }

    session()->forget('cart');
    $order->update([
    'status' => 'confirmed',
    'payment_status' => 'Pending'
    ]);

    return redirect()->route('orders.my')
        ->with('success', 'Order placed successfully.');
}

    // STRIPE PAYMENT
    if ($request->payment_method == 'stripe') {

        return redirect()->route('stripe.checkout', [
            'order_id' => $order->id
        ]);

    }

    return back();
}
public function allOrders()
{
    $orders = Order::with('items')->latest()->get();
    return view('admin.orders', compact('orders'));
}
public function updateOrderStatus(Request $request, Order $order)
{
    $request->validate([
        'status' => 'required|in:pending,shipped,delivered,cancelled'
    ]);

    $order->update(['status' => $request->status]);

    return back()->with('success', 'Order #'.$order->id.' status updated to '.$request->status);
}
    public function orderViaWhatsApp(Request $request)
{
    $cart = session()->get('cart', []);
    
    if(empty($cart)) {
        return back()->with('error', 'Your cart is empty');
    }

    $message = "🛒 *New Order from Website* %0a%0a";
    $message .= "*Customer Details* %0a";
    $message .= "Name: " . $request->name . "%0a";
    $message .= "Phone: " . $request->phone . "%0a";
    $message .= "Address: " . $request->address . "%0a%0a";
    
    $message .= "*Order Items* %0a";
    $total = 0;
    
    foreach($cart as $id => $details) {
        $subtotal = $details['price'] * $details['quantity'];
        $total += $subtotal;
        $message .= $details['name'] . " x " . $details['quantity'] . " = Rs " . $subtotal . "%0a";
    }
    
    $message .= "%0a*Total: Rs " . $total . "*";

    // YAHAN APNA WHATSAPP NUMBER LIKHO 92 se start
    $whatsappNumber = "923474675568"; 
    
    $whatsappUrl = "https://wa.me/" . $whatsappNumber . "?text=" . $message;

    // Cart khali kar do order ke baad
    session()->forget('cart');

    return redirect($whatsappUrl);
}

public function adminCategoryProducts(Category $category, Request $request)
{
    $query = Product::where('category_id', $category->id);

    if($request->filled('search')){
        $query->where('name', 'like', '%'.$request->search.'%');
    }

    $products = $query->latest()->get();
    return view('admin.category', compact('category', 'products'));
}

public function adminProducts(Request $request)
{
    $query = Product::with('category');

    if($request->filled('search')){
        $query->where('name', 'like', '%'.$request->search.'%');
    }

    $sort = $request->sort;
    if($sort == 'price_low') $query->orderBy('price', 'asc');
    elseif($sort == 'price_high') $query->orderBy('price', 'desc');
    else $query->latest();

    $products = $query->get();
    return view('admin.products.index', compact('products')); // IMPORTANT
}

public function increase($id)
{
    $cart = session()->get('cart', []);

    if(isset($cart[$id])){
        $cart[$id]['quantity']++;
        session()->put('cart', $cart);
    }

    return back();
}

public function decrease($id)
{
    $cart = session()->get('cart', []);

    if(isset($cart[$id])){

        if($cart[$id]['quantity'] > 1){
            $cart[$id]['quantity']--;
        }else{
            unset($cart[$id]);
        }

        session()->put('cart', $cart);
    }

    return back();
}
    public function myOrders()
    {
        $orders = Order::with('items')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    } 


}