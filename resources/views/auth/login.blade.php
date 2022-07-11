<x-guest-layout>
    <form class="mt-8" action="/login" method="POST">
        @csrf
        <input type="hidden" name="remember" value="true">
        <div class="form__login">
            <div class="mb-3">
                <label for="email-address" class="text-gray-700 font-medium block mb-2">Email</label>
                <input id="email-address" name="email" type="email" autocomplete="email" required
                    class="placeholder:text-gray-500 block w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:border-indigo-500 focus:placeholder:text-transparent focus:ring-1 sm:text-sm"
                    placeholder="Enter your email">
            </div>
            <div class="mb-4">
                <label for="password" class="text-gray-700 font-medium block mb-2">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                    class="placeholder:text-gray-500 block w-full border border-gray-300 rounded-md py-2 px-3 shadow-sm focus:outline-none focus:border-indigo-500 focus:placeholder:text-transparent focus:ring-1 sm:text-sm"
                    placeholder="••••••••••">
            </div>
        </div>

        <div class="flex items-center justify-between space-x-6 mb-4">
            <div class="flex items-center">
                <input id="remember-me" name="remember-me" type="checkbox"
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <label for="remember-me" class="ml-2 block text-sm text-gray-900 font-medium">Remember me</label>
            </div>

            <div class="text-sm">
                <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">Forgot your password?</a>
            </div>
        </div>

        <div>
            <button type="submit"
                class="w-full py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Sign in
            </button>

            <div class="pt-6">
                <p class="text-sm text-center">
                    <span class="text-gray-600">Don't have an account?</span>
                    <a href="/register" class="text-gray-900 hover:text-indigo-700 font-bold">Sign up for free</a>
                </p>
            </div>
        </div>
    </form>
</x-guest-layout>
