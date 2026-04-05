<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">مرحباً بعودتك</h2>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">سجل الدخول إلى حسابك</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Username with floating label effect -->
        <div class="relative">
            <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus
                   class="peer w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-transparent text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all duration-200"
                   placeholder=" ">
            <label for="username"
                   class="absolute right-3 top-3 text-gray-500 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:-top-2 peer-focus:text-sm peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 bg-white/80 dark:bg-gray-900/80 px-1">
                اسم المستخدم
            </label>
            @error('username')
            <p class="text-red-500 text-xs mt-1 pr-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password with floating label -->
        <div class="relative">
            <input id="password" type="password" name="password" required
                   class="peer w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 bg-transparent text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 outline-none transition-all duration-200"
                   placeholder=" ">
            <label for="password"
                   class="absolute right-3 top-3 text-gray-500 dark:text-gray-400 transition-all duration-200 peer-placeholder-shown:top-3 peer-placeholder-shown:text-base peer-focus:-top-2 peer-focus:text-sm peer-focus:text-indigo-600 dark:peer-focus:text-indigo-400 bg-white/80 dark:bg-gray-900/80 px-1">
                كلمة المرور
            </label>
            @error('password')
            <p class="text-red-500 text-xs mt-1 pr-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember me -->
        <div class="flex items-center justify-between">
            <label class="inline-flex items-center cursor-pointer group">
                <input type="checkbox" name="remember"
                       class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:bg-gray-800">
                <span class="mr-2 text-sm text-gray-600 dark:text-gray-400 group-hover:text-indigo-600 transition-colors">تذكرني</span>
            </label>
        </div>

        <!-- Submit button -->
        <button type="submit"
                class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
            دخول
        </button>
    </form>

    <!-- Optional: extra links (if any) -->
    @if (Route::has('password.request'))
        <div class="text-center mt-6">
            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">
                نسيت كلمة المرور؟
            </a>
        </div>
    @endif
</x-guest-layout>
