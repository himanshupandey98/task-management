<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tailwind</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="w-full max-w-sm bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center text-gray-700">Login</h2>

        <!-- Error Messages -->
        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mt-4">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('login') }}" method="POST" class="mt-4">
            @csrf

            <!-- Email Input -->
            <div>
                <label class="block text-gray-700">Email</label>
                <input type="email" name="email" placeholder="Enter email address" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Password Input -->
            <div class="mt-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" placeholder="Enter password" required
                    class="w-full px-4 py-2 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <!-- Login Button -->
            <button type="submit" class="w-full mt-6 px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none">
                Login
            </button>
        </form>


    </div>
</body>

</html>