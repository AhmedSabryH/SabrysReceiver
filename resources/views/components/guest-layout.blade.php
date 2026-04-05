<!DOCTYPE html>
<html lang="ar" dir="rtl" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Sabry\'s Receiver') }} - {{ $title ?? 'الدخول' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Smooth transitions for dark mode */
        * {
            transition: background-color 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
        }
        /* Custom gradient animation (optional) */
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .animated-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-size: 200% 200%;
            animation: gradientShift 8s ease infinite;
        }
        .dark .animated-bg {
            background: linear-gradient(135deg, #1e1b4b 0%, #2e1065 100%);
        }
    </style>
</head>
<body class="font-sans antialiased">
<div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 overflow-hidden">
    <!-- Animated background -->
    <div class="fixed inset-0 -z-10 animated-bg opacity-30 dark:opacity-20"></div>
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-indigo-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900"></div>

    <!-- Dark mode toggle (floating button) -->
    <div class="fixed top-4 left-4 z-20">
        <button @click="darkMode = !darkMode" class="p-2 rounded-full bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-md hover:shadow-lg transition-all duration-300 hover:scale-105">
            <span x-show="!darkMode" class="text-yellow-600 text-xl">🌙</span>
            <span x-show="darkMode" class="text-yellow-300 text-xl">☀️</span>
        </button>
    </div>

    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-black bg-gradient-to-r from-indigo-700 to-purple-700 dark:from-indigo-400 dark:to-purple-400 bg-clip-text text-transparent">
            📨 Sabry's Receiver
        </h1>
        <p class="text-gray-600 dark:text-gray-400 text-sm mt-2 font-medium">نظام استلام الرسائل والإشعارات</p>
    </div>

    <!-- Glass card -->
    <div class="w-full sm:max-w-md px-6 py-8 bg-white/80 dark:bg-gray-900/80 backdrop-blur-lg shadow-2xl rounded-2xl border border-white/20 dark:border-gray-700/50 transition-all duration-500">
        {{ $slot }}
    </div>

    <!-- Footer (optional) -->
    <div class="mt-8 text-center text-xs text-gray-500 dark:text-gray-500">
        © {{ date('Y') }} Sabry's Receiver — جميع الحقوق محفوظة
    </div>
</div>
</body>
</html>
