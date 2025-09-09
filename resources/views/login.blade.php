<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | Chef K Accounting</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ✅ Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .bg-login {
            background-color: #e7f0ff;
            min-height: 100vh;
        }
        .btn-animate:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="bg-login flex items-center justify-center">
    <div class="w-full max-w-md p-8 bg-white shadow-lg rounded-lg">
        <div class="text-center mb-6">
            
            <h2 class="text-2xl font-semibold text-gray-800">Sign In</h2>
        </div>

        {{-- Error messages --}}
        @if ($errors->any())
            <div class="mb-4 text-sm text-red-600">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}" onsubmit="disableButton()">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 text-sm mb-1">Username <span class="text-red-500">*</span></label>
                <input type="text" name="username" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" placeholder="Enter your username" required>
            </div>

            <div class="mb-4 relative">
                <label class="block text-gray-700 text-sm mb-1">Password <span class="text-red-500">*</span></label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" placeholder="Enter your password" required>
                <button type="button" onclick="togglePassword()" class="absolute right-3 top-9 text-sm text-blue-500 hover:underline">Show</button>
            </div>

            <button type="submit" id="loginBtn" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded btn-animate transition-all">
                Sign In
            </button>
        </form>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const button = event.target;
            if (input.type === 'password') {
                input.type = 'text';
                button.innerText = 'Hide';
            } else {
                input.type = 'password';
                button.innerText = 'Show';
            }
        }

        function disableButton() {
            const btn = document.getElementById('loginBtn');
            btn.disabled = true;
            btn.innerText = 'Signing in...';
        }
    </script>
</body>
</html>
