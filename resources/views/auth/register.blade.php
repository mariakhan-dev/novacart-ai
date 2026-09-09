<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register | NovaCart AI</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-slate-900 via-blue-900 to-indigo-900 min-h-screen flex items-center justify-center">

<div class="bg-white rounded-3xl shadow-2xl p-10 w-full max-w-md">

    <h1 class="text-4xl font-bold text-center mb-2">
        NovaCart <span class="text-blue-600">AI</span>
    </h1>

    <p class="text-center text-gray-500 mb-8">
        Create your account
    </p>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-5">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <input
            type="text"
            name="name"
            placeholder="Full Name"
            required
            class="w-full border rounded-xl px-4 py-3 mb-4">

        <input
            type="email"
            name="email"
            placeholder="Email"
            required
            class="w-full border rounded-xl px-4 py-3 mb-4">

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
            class="w-full border rounded-xl px-4 py-3 mb-4">

        <input
            type="password"
            name="password_confirmation"
            placeholder="Confirm Password"
            required
            class="w-full border rounded-xl px-4 py-3 mb-6">

        <button
            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-bold">

            Create Account

        </button>
    </form>

    <p class="text-center mt-6">
        Already have an account?
        <a href="{{ route('login') }}" class="text-blue-600 font-bold">
            Login
        </a>
    </p>

</div>

</body>
</html>