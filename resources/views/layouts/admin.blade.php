<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <title>Admin - Ecommerce-AI</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">

    <!-- ADMIN NAVBAR -->
<!-- ADMIN NAVBAR -->
<nav class="sticky top-0 z-50 backdrop-blur-lg bg-slate-900/95 shadow-xl border-b border-slate-800">

    <div class="max-w-7xl mx-auto px-6">

        <div class="h-20 flex justify-between items-center">

            <!-- Logo -->
            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3">

                <div class="w-12 h-12 rounded-xl bg-orange-500 flex items-center justify-center text-white text-2xl shadow-lg">
                    ⚙️
                </div>

                <div>
                    <h1 class="text-2xl font-extrabold text-white">
                        NovaCart
                        <span class="text-orange-400">Admin</span>
                    </h1>

                    <p class="text-xs text-slate-400">
                        Management Dashboard
                    </p>
                </div>

            </a>

            <!-- Menu -->
            <!-- Menu -->
<div class="hidden md:flex items-center gap-8">

    <a href="{{ route('admin.products.index') }}"
       class="text-white hover:text-orange-400 font-semibold transition">
        📦 Products
    </a>

    <a href="{{ route('admin.orders') }}"
       class="text-white hover:text-orange-400 font-semibold transition">
        🛒 Orders
    </a>

    <a href="{{ route('admin.categories.index') }}"
       class="text-white hover:text-orange-400 font-semibold transition">
        📂 Categories
    </a>

    <a href="{{ route('shop') }}"
       class="bg-orange-500 hover:bg-orange-600 px-5 py-2 rounded-xl
              text-white font-semibold transition">
        🛍 View Shop
    </a>

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

                    <div class="w-12 h-12 rounded-xl bg-orange-500 flex items-center justify-center text-white text-2xl shadow-lg">
                    ⚙️
                </div>

                    <div>
                        <h2 class="text-2xl font-bold text-white">
                            NovaCart AI
                        </h2>

                        <p class="text-sm text-gray-400">
                            Admin Dashboard
                        </p>
                    </div>

                </div>

                <p class="leading-7">
                    Manage products, categories, inventory and customer
                    orders from one powerful dashboard.
                </p>

            </div>

            <!-- Quick Links -->
            <div>

                <h3 class="text-xl font-semibold text-white mb-5">
                    Quick Links
                </h3>

                <ul class="space-y-3">

                    <li>
                        <a href="{{ route('admin.products.index') }}" class="hover:text-blue-400">
                            Products
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="hover:text-blue-400">
                            Categories
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.orders') }}" class="hover:text-blue-400">
                            Orders
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
                            <a href="{{ route('admin.category.products',$cat) }}"
                               class="hover:text-blue-400">

                                {{ $cat->name }}

                            </a>
                        </li>

                    @endforeach

                </ul>

            </div>

            <!-- Dashboard -->
            <div>

                <h3 class="text-xl font-semibold text-white mb-5">
                    Dashboard
                </h3>

                <div class="space-y-3">

                    <p>📦 Products</p>

                    <p>📂 Categories</p>

                    <p>🧾 Orders</p>

                    <p>🛒 NovaCart AI Admin</p>

                </div>

            </div>

        </div>

        <div class="border-t border-slate-700 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">

            <p>
                © {{ date('Y') }} NovaCart AI Admin Panel.
            </p>

            <p class="text-gray-500 mt-4 md:mt-0">
                Developed with ❤️ using Laravel & Tailwind CSS
            </p>

        </div>

    </div>

</footer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>

