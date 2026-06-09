<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="container mx-auto py-10">
        @if (Route::has('login'))
            <div class="flex justify-end gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                    <a href="{{ url('/products') }}">Products</a>
                @else
                    <a href="{{ route('login') }}">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="text-center mt-10">
            <h1>Role-Based Product Management System</h1>
            <p>Laravel + Spatie Permission</p>
            @auth
                <div class="flex flex-col items-center gap-2 mt-10">
                    <span>Welcome, {{ auth()->user()->name }}</span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="px-4 py-2 bg-red-500 text-white rounded"
                        >
                            Logout
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</body>
</html>