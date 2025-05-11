
<x-guest-layout>
    {{-- Logo / Title --}}
    <div class="text-center mb-6">
        <h1 class="text-3xl font-extrabold tracking-wider text-gray-900 dark:text-gray-100">
            Takaful Admin Login
        </h1>
    </div>

    {{-- Card (no elevation) --}}
    <div class="w-full sm:max-w-md mx-auto px-6 py-4 bg-white dark:bg-gray-800 sm:rounded-lg">
        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="mb-4">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                    {{ __('Email') }}
                </label>
                <input id="email"
                       type="email"
                       name="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       placeholder="you@example.com" />
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">
                    {{ __('Password') }}
                </label>
                <input id="password"
                       type="password"
                       name="password"
                       required
                       autocomplete="current-password"
                       class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-md focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                       placeholder="••••••••" />
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center mb-4">
                <input id="remember_me" type="checkbox" name="remember"
                       class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500">
                <label for="remember_me" class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('Remember me') }}
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <button type="submit"
                        class="ml-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-wider hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
