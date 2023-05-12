<x-guest-layout>
    <form class="mt-8 space-y-6" action="/register" method="POST">
        @csrf
        <input type="hidden" name="remember" value="true">
        <div class="form__login">
            <div class="mb-3">
                <label for="name" class="text-gray-700 font-medium block mb-2">{{ __('Name') }}</label>
                <input id="name" name="name" type="text" autocomplete="name" autofocus
                       class="placeholder:text-gray-500 block w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:border-indigo-500 focus:placeholder:text-transparent focus:ring-1 sm:text-sm"
                       placeholder="{{ __('Name') }}" value="{{ old('name') }}">
            </div>
            <div class="mb-3">
                <label for="email-address" class="text-gray-700 font-medium block mb-2">{{ __('Email') }}</label>
                <input id="email-address" name="email" type="email" autocomplete="email"
                       class="placeholder:text-gray-500 block w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:border-indigo-500 focus:placeholder:text-transparent focus:ring-1 sm:text-sm"
                       placeholder="{{ __('Email') }}" value="{{ old('email') }}">
            </div>
            <div class="mb-4">
                <label for="password" class="text-gray-700 font-medium block mb-2">{{ __('Password') }}</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                       class="placeholder:text-gray-500 block w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:border-indigo-500 focus:placeholder:text-transparent focus:ring-1 sm:text-sm"
                       placeholder="••••••••••">
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="text-gray-700 font-medium block mb-2">{{ __('Confirm Password') }}</label>
                <input id="password_confirmation" name="password_confirmation" type="password"
                       class="placeholder:text-gray-500 block w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:border-indigo-500 focus:placeholder:text-transparent focus:ring-1 sm:text-sm"
                       placeholder="••••••••••">
            </div>
        </div>

        @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li class="text-red-600 font-bold"> {{ __($error) }}</li>
                @endforeach
            </ul>
        @endif
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <x-flash-message></x-flash-message>
        </div>

        <div>
            <button type="submit"
                    class="w-full py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Register') }}
            </button>

            <div class="pt-6">
                <p class="text-sm text-center">
                    <span class="text-gray-600">{{ __('Already have an account?') }}</span>
                    <a href="/login" class="text-gray-900 hover:text-indigo-700 font-bold">{{ __('Login') }}</a>
                </p>
            </div>
        </div>
    </form>
</x-guest-layout>
