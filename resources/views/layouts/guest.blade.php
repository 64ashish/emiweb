<!doctype html>
<html class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="h-full">
<div class="min-h-full flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="text-center font-extrabold">EMIWEB</div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                @if(Route::is('register') )
                    Register for an account
                @else
                    Sign in to your account
                @endif
            </h2>

        </div>
        @if($errors->any())
            <ul>
                @foreach($errors->all() as $error)
                    <li> {{ $error }}</li>
                @endforeach
            </ul>
        @endif
        {{ $slot }}
    </div>
</div>
</body>
</html>
