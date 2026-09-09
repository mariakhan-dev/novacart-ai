<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;
use Illuminate\Routing\Controller;

class AIController extends Controller
{
    public function chat(Request $request)
{
    $request->validate([
        'message' => 'required|string',
    ]);

    $message = strtolower(trim($request->message));

    /*
    |--------------------------------------------------------------------------
    | COMPARE PRODUCTS
    |--------------------------------------------------------------------------
    */

    if (str_contains($message, 'compare')) {

        $allProducts = Product::with('category')->get();

        $matched = [];

        foreach ($allProducts as $product) {

            $productName = strtolower($product->name);

            $words = preg_split('/\s+/', $message);

            foreach ($words as $word) {

                $word = preg_replace('/[^a-z0-9]/', '', $word);

                if (strlen($word) < 3) {
                    continue;
                }

                if (str_contains($productName, $word)) {

                    $matched[$product->id] = $product;

                    break;
                }
            }
        }

        $matched = array_values($matched);

        if (count($matched) >= 2) {

            $comparePrompt = "
You are NovaCart AI.

Compare ONLY these real products.

Do NOT invent information.

";

            foreach ($matched as $product) {

                $comparePrompt .= "
Product: {$product->name}
Category: {$product->category->name}
Price: Rs {$product->price}
Description: {$product->description}

";
            }

            $comparePrompt .= "
Compare them briefly.

Mention:
- Price
- Main difference
- Best choice

Maximum 4 short sentences.
";

            $response = Http::withToken(env('GROQ_API_KEY'))
                ->post('https://api.groq.com/openai/v1/chat/completions', [

                    'model' => 'llama-3.1-8b-instant',

                    'temperature' => 0.2,

                    'max_tokens' => 120,

                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $comparePrompt
                        ]
                    ]
                ]);

            return response()->json([

                'reply' => $response['choices'][0]['message']['content'] ?? 'Unable to compare products.',

                'products' => collect($matched)->map(function ($product) {

                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'image' => asset('storage/' . $product->image),
                        'url' => route('product.show', $product),
                    ];

                })->values()

            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | SMART PRODUCT SEARCH
    |--------------------------------------------------------------------------
    */

    // Remove common conversational words
    $cleanMessage = preg_replace(
        '/\b(i|need|want|a|an|the|me|please|show|find|looking|for|some|give|have|you|can|could|would|like|product|products|buy|purchase)\b/i',
        ' ',
        $message
    );

    // Extract useful words
    $keywords = preg_split('/\s+/', trim($cleanMessage));

    $keywords = array_filter($keywords, function ($word) {
        return strlen($word) >= 3;
    });


    /*
    |--------------------------------------------------------------------------
    | SEARCH DATABASE
    |--------------------------------------------------------------------------
    */

    $productsQuery = Product::with('category');

    $productsQuery->where(function ($query) use ($keywords) {

        foreach ($keywords as $keyword) {

            $query->orWhere('name', 'like', "%{$keyword}%")

                  ->orWhere('description', 'like', "%{$keyword}%")

                  ->orWhereHas('category', function ($categoryQuery) use ($keyword) {

                      $categoryQuery->where(
                          'name',
                          'like',
                          "%{$keyword}%"
                      );

                  });
        }

    });


    $products = $productsQuery
        ->where('stock', '>', 0)
        ->take(5)
        ->get();


    /*
    |--------------------------------------------------------------------------
    | CHEAP / LOW PRICE REQUEST
    |--------------------------------------------------------------------------
    */

    if (
        str_contains($message, 'cheap') ||
        str_contains($message, 'cheapest') ||
        str_contains($message, 'affordable')
    ) {

        $products = $products
            ->sortBy('price')
            ->values();
    }


    /*
    |--------------------------------------------------------------------------
    | NO MATCHING PRODUCT
    |--------------------------------------------------------------------------
    */

    if ($products->isEmpty()) {

        return response()->json([

            'reply' => "Sorry, I couldn't find a matching product in NovaCart right now.",

            'products' => []

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | SEND ONLY REAL PRODUCTS TO AI
    |--------------------------------------------------------------------------
    */

    $storeProducts = "";

    foreach ($products as $product) {

        $storeProducts .=
            "Product: {$product->name}\n" .
            "Category: {$product->category->name}\n" .
            "Price: Rs {$product->price}\n" .
            "Description: {$product->description}\n\n";
    }


    $prompt = "
You are NovaCart AI, the shopping assistant for NovaCart.

IMPORTANT RULES:

1. ONLY talk about the products listed below.
2. NEVER invent products.
3. NEVER mention products that are not listed below.
4. NEVER claim NovaCart is under re-launch.
5. NEVER suggest random alternatives.
6. If the listed products match the customer's request, recommend them.
7. If they don't match, politely say you could not find a matching product.
8. Keep the answer SHORT.
9. Maximum 3 short sentences.
10. Mention the actual product name when recommending something.
11. If the customer wants to buy, say:
'Open the product page, click Add to Cart, then proceed to Checkout or Order via WhatsApp.'

AVAILABLE NOVACART PRODUCTS:

{$storeProducts}

CUSTOMER MESSAGE:

{$request->message}
";


    $response = Http::withToken(env('GROQ_API_KEY'))
        ->post('https://api.groq.com/openai/v1/chat/completions', [

            'model' => 'llama-3.1-8b-instant',

            'temperature' => 0.2,

            'max_tokens' => 100,

            'messages' => [

                [
                    'role' => 'system',
                    'content' => $prompt
                ]

            ]

        ]);


    return response()->json([

        'reply' => $response['choices'][0]['message']['content']
            ?? 'Sorry, I could not process your request.',

        'products' => $products->map(function ($product) {

            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => asset('storage/' . $product->image),
                'url' => route('product.show', $product),
            ];

        })->values()

    ]);
}
}
