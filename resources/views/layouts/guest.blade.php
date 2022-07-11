<!doctype html>
<html class="h-full bg-gray-50">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="h-full">
<div class="min-h-full md:flex bg-white">
    <div class="md:flex-none md:w-1/2 min-h-screen flex items-center justify-center p-6 md:p-0">
        <div class="lg:w-2/3 xl:w-1/2">
            <div>
                <h2 class="text-2xl lg:text-4xl text-gray-900 font-bold mb-3">Welcome back</h2>
                <h4 class="text-gray-600">
                    @if(Route::is('register') )
                        Register for an account
                    @else
                        Sign in to your account
                    @endif
                </h4>
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
    <div class="hidden md:block md:flex-none md:w-1/2">
        <img class="w-full h-full object-cover"
             src="{{ asset('images/guest.jpg') }}"
             alt="welcome">
    </div>
</div>
</body>

</html>
