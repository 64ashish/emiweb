<!doctype html>
<html class="h-full bg-gray-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.lordicon.com/lusqsztk.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full">
<div class="min-h-full">

    <header class="pb-28 pt-12 bg-indigo-600 ">
{{--        for desktop--}}
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8 flex justify-between">
            <div class="flex items-center">
                @role('organization admin')
                <a href="{{ route('dashboard')  }}"  aria-current="page">
                    <img src="/images/logo.png" class="hidden lg:inline-block	">
                    <img src="/images/emiweb-mobile-logo.png" class=" lg:hidden">
                </a>
                @endrole
                @if(auth()->user()->hasRole('regular user|subscriber'))
                    <a href="{{ route('home')  }}"  aria-current="page">
                        <img src="/images/logo.png" class="hidden lg:inline-block	">
                        <img src="/images/emiweb-mobile-logo.png" class=" lg:hidden">
                    </a>
                @endif
                {!! Form::open([ 'route'=>'local' ]) !!}
                <ul class="pl-16 text-white font-bold inline-flex">
                    <li ><button name="language" value="sv" type="submit">SV</button> /</li>
                    <li class="px-1"><button name="language" value="en" type="submit">EN</button> </li>
                </ul>
                {!! Form::close() !!}
            </div>
            <div>
                <ul class="font-bold inline-flex text-white">
                    <li class="pr-8">

                        <div>
                            <div class="max-w-md w-full mx-auto flex justify-end"   x-data="{ openSearch: false }">
                                <svg  @click="openSearch = true; $nextTick(() => $refs.input.focus())"
                                      xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white cursor-pointer"
                                      fill="none"
                                      viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                {{--                            search starts from here --}}

                                <div x-show="openSearch"
                                     x-transition:enter="ease-out duration-300"
                                     x-transition:enter-start="opacity-0"
                                     x-transition:enter-end="opacity-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100"
                                     x-transition:leave-end="opacity-0"
                                     class="fixed inset-0 z-20 overflow-y-auto p-4 sm:p-6 md:p-20"
                                     role="dialog" aria-modal="true" style="display:none">

                                    <div  class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity" aria-hidden="true"></div>


                                    <div x-transition:enter="ease-out duration-300"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="ease-in duration-200"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 opacity-100 scale-100"
                                         class="mx-auto max-w-xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
                                        <div class="relative" @click.away="openSearch = false">
                                            <!-- Heroicon name: solid/search -->
                                            <svg class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                            </svg>


                                            {!! Form::open(['route' => 'search'])  !!}
                                            <input x-ref="input" name="search" type="text" class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm"
                                                   placeholder="{{ __('Search') }}..."  aria-expanded="false"
                                                   aria-controls="options">
                                            <input type="submit" hidden />
                                            {!! Form::close() !!}
                                        </div>



                                    </div>
                                </div>


                            </div>
                        </div>

                    </li>
                    <li class="pl-8">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">{{ __('Logout') }}</button>
                        </form>
                        </li>
                </ul>
            </div>
        </div>

{{--        for mobile--}}

        <div>

        </div>

    </header>
    <main class="-mt-24 pb-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <x-flash-message></x-flash-message>
            </div>

            {{ $slot }}


        </div>

    </main>
    <footer>
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">
            <div class="border-t border-gray-200 py-8 text-sm text-gray-500 text-center sm:text-left"><span class="block sm:inline">2022 Kortaben.</span> <span class="block sm:inline">All rights reserved.</span></div>
        </div>
    </footer>
</div>
</body>
<script>

</script>
</html>
