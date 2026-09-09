<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request, Product $product)
{
    $favorite = Favorite::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->first();

    if ($favorite) {

        $favorite->delete();

    } else {

        Favorite::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

    }

    return redirect()->route('shop');
}
}