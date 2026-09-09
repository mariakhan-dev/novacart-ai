<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>NovaCart AI | Smart Shopping</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <!-- SHOP NAVBAR -->
<nav class="sticky top-0 z-50 backdrop-blur-lg bg-slate-900/95 shadow-xl border-b border-slate-800">

    <div class="max-w-7xl mx-auto px-6">

        <div class="h-20 flex justify-between items-center">

            <!-- LOGO -->

            <a href="{{ auth()->check() && auth()->user()->role == 'admin'
        ? route('admin.products.index')
        : route('shop') }}"
   class="flex items-center gap-3">

                <div class="w-12 h-12 rounded-xl bg-blue-600 flex items-center justify-center text-white text-2xl shadow-lg">
                    🛍
                </div>

                <div>

                    <h1 class="text-2xl font-extrabold text-white">
                        NovaCart
                        <span class="text-blue-400">AI</span>
                    </h1>

                    <p class="text-xs text-slate-400">
                        Smart Shopping Platform
                    </p>

                </div>

            </a>

            <!-- MENU -->

            <div class="hidden md:flex items-center gap-8">

                <a href="{{ route('shop') }}"
                   class="text-white hover:text-blue-400 transition font-semibold">

                    Home

                </a>

                <!-- CATEGORY -->

                <div class="relative group">

                    <button
                    class="flex items-center gap-2 text-white hover:text-blue-400 font-semibold">

                        Categories

                        <svg
                        class="w-4 h-4"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                            <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"/>

                        </svg>

                    </button>

                    <div
                    class="absolute left-0 mt-5 hidden group-hover:block">

                        <div
                        class="w-60 rounded-2xl bg-white shadow-2xl overflow-hidden">

                            @foreach(\App\Models\Category::all() as $cat)

                                <a
                                href="{{ route('category.show',$cat) }}"
                                class="block px-5 py-3 hover:bg-gray-100 transition">

                                    {{ $cat->name }}

                                </a>

                            @endforeach

                        </div>

                    </div>

                </div>

                <!-- CART -->

                <a
                href="{{ route('cart.index') }}"
                class="relative flex items-center gap-2 text-white hover:text-orange-400 transition">

                    🛒

                    <span class="font-semibold">

                        Cart

                    </span>

                    <span
                    class="absolute -top-3 -right-4 bg-red-500 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center">

                        {{ array_sum(array_column(session('cart', []), 'quantity')) }}

                    </span>

                </a>
                @auth

<a href="{{ route('orders.my') }}"
   class="text-white hover:text-blue-400 transition font-semibold">

    My Orders

</a>

@endauth

                @guest

<a href="{{ route('login') }}"
   class="text-white hover:text-blue-400 font-semibold transition">
    Login
</a>

<a href="{{ route('register') }}"
   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl font-semibold transition">
    Sign Up
</a>

@endguest
@auth

@if(auth()->user()->role == 'admin')

<a href="{{ route('admin.products.index') }}"
   class="text-orange-400 hover:text-orange-300 font-semibold transition">
    Dashboard
</a>

@endif

<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl font-semibold transition">
        Logout
    </button>
</form>

@endauth

            </div>

        </div>

    </div>

</nav>

<div class="h-8"></div>

    <main class="flex-1">@yield('content')</main>

    <!-- FOOTER -->
<footer class="bg-slate-900 text-gray-300 mt-20">

    <div class="max-w-7xl mx-auto px-6 py-16">

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-10">

            <!-- Brand -->

            <div>

                <div class="flex items-center gap-3 mb-5">

                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-2xl">
                        🛍
                    </div>

                    <div>

                        <h2 class="text-2xl font-bold text-white">
                            NovaCart AI
                        </h2>

                        <p class="text-sm text-gray-400">
                            Smart Shopping Platform
                        </p>

                    </div>

                </div>

                <p class="leading-7">

                    NovaCart AI provides a modern shopping experience
                    powered by intelligent recommendations,
                    secure ordering and beautiful user experience.

                </p>

            </div>

            <!-- Quick Links -->

            <div>

                <h3 class="text-xl font-semibold text-white mb-5">
                    Quick Links
                </h3>

                <ul class="space-y-3">

                    <li>
                        <a href="{{ route('shop') }}" class="hover:text-blue-400">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('cart.index') }}" class="hover:text-blue-400">
                            Cart
                        </a>
                    </li>

                    <li>
                        <a href="#" class="hover:text-blue-400">
                            AI Assistant
                        </a>
                    </li>

                    <li>
                        <a href="#" class="hover:text-blue-400">
                            Contact Us
                        </a>
                    </li>

                </ul>

            </div>

            <!-- Categories -->

            <div>

                <h3 class="text-xl font-semibold text-white mb-5">
                    Categories
                </h3>

                <ul class="space-y-3">

                    @foreach(\App\Models\Category::take(5)->get() as $cat)

                        <li>

                            <a href="{{ route('category.show',$cat) }}"
                               class="hover:text-blue-400">

                                {{ $cat->name }}

                            </a>

                        </li>

                    @endforeach

                </ul>

            </div>

            <!-- Contact -->

            <div>

                <h3 class="text-xl font-semibold text-white mb-5">

                    Contact

                </h3>

                <div class="space-y-3">

                    <p>📍 Kalabagh, Punjab, Pakistan</p>

                    <p>📧 support@novacartai.com</p>

                    <p>📞 +92 300 1234567</p>

                    <div class="flex gap-4 text-2xl pt-3">

                        <span class="hover:scale-110 cursor-pointer transition">📘</span>

                        <span class="hover:scale-110 cursor-pointer transition">📷</span>

                        <span class="hover:scale-110 cursor-pointer transition">🐦</span>

                        <span class="hover:scale-110 cursor-pointer transition">💼</span>

                    </div>

                </div>

            </div>

        </div>

        <div class="border-t border-slate-700 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">

            <p>

                © {{ date('Y') }} NovaCart AI. All Rights Reserved.

            </p>

            <p class="text-gray-500 mt-4 md:mt-0">

                Developed with ❤️ using Laravel & Tailwind CSS

            </p>

        </div>

    </div>

</footer>
<x-ai-chat />
</body>
</html>
