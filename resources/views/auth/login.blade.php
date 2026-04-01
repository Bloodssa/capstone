<x-guest-layout>
    <!-- Session Status -->
    @if (session('status'))
        <x-ui.toast type="success" message="{{ session('status') }}" />
    @endif

    @if (session('error'))
        <x-ui.toast type="error" message="{{ session('error') }}" />
    @endif

    <form method="POST" action="{{ route('login') }}" class="py-2 px-3">
        @csrf

        <div class="flex flex-col items-center space-y-3">
            <x-icons.mark />

            <div class="flex flex-col items-center">
                <h1 class="text-2xl font-bold leading-tight tracking-tight text-neutral-900 md:text-3xl">
                    Welcome Back
                </h1>
                <p class="text-gray-500 mt-1">Sign in to access your warranty records</p>
            </div>
        </div>

        <!-- Email Address -->
        <div>
            <x-forms.input-label for="email" :value="__('Email')" />
            <x-forms.text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autofocus autocomplete="username" />
            <x-forms.input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-forms.input-label for="password" :value="__('Password')" />

            <x-forms.text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-forms.input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="space-y-4">
            <div class="block mt-4 flex flex-col space-y-3 sm:flex-row justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="rounded-md border-gray-300 text-neutral-900 focus:ring-neutral-900"
                        name="remember">
                    <span class="ms-2 text-sm text-neutral-900">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-neutral-900 hover:text-neutral-600 rounded-md focus:outline-none"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-ui.primary-button class="w-full text-center">
                    {{ __('Log in') }}
                </x-ui.primary-button>
            </div>

            <x-icons.line />

            <div class="w-full h-10">
                <a href="{{ route('auth.google') }}"
                    class="flex items-center justify-center w-full px-4 py-2.5 space-x-3 text-sm outline-none font-medium text-neutral-900 bg-white border border-gray-300 rounded-md hover:bg-gray-100 hover transition-all duration-200 ease-in-out">

                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48">
                        <path fill="#FFC107"
                            d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24s8.955,20,20,20s20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z">
                        </path>
                        <path fill="#FF3D00"
                            d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z">
                        </path>
                        <path fill="#4CAF50"
                            d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z">
                        </path>
                        <path fill="#1976D2"
                            d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z">
                        </path>
                    </svg>

                    <span>Continue with Google</span>
                </a>
            </div>
        </div>

        <div class="flex justify-center mt-4 space-x-1">
            <p class="text-sm font-light text-gray-500 text-center ">
                Don’t have an account yet?
                <a href="{{ route('register') }}" class="font-medium text-neutral-900 hover:underline">Sign up</a>
            </p>
        </div>
    </form>
</x-guest-layout>
