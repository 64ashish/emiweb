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

    <header class="pb-24 bg-indigo-600" x-data="{ openMobile: false }">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="relative py-5 flex items-center justify-center lg:justify-between">
                <!-- Logo -->
                <div class="absolute left-0 flex-shrink-0 lg:static">

                        <lord-icon
                                src="https://cdn.lordicon.com/gqzfzudq.json"
                                trigger="loop"
                                colors="primary:#ffffff,secondary:#08a88a"
                                style="width:35px;height:35px">
                        </lord-icon>

                </div>



                <!-- Right section on desktop -->
                <div class="hidden lg:ml-4 lg:flex lg:items-center lg:pr-0.5">

                    <!-- Profile dropdown -->
                    <div class="ml-4 relative flex-shrink-0" x-data="{ openDesk: false }">
                        <div>
                            <button @click="openDesk = true" type="button" class="bg-white rounded-full flex text-sm ring-2 ring-white ring-opacity-20 focus:outline-none focus:ring-opacity-100" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </button>
                        </div>


                        <div x-show="openDesk" @click.away="openDesk = false" class="origin-top-right z-40 absolute -right-2
                        mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5
                        focus:outline-none" role="menu" aria-orientation="vertical"
                             aria-labelledby="user-menu-button" tabindex="-1"
                             x-transition:enter="transition ease-out origin-top-right duration-200"
                             x-transition:enter-start="opacity-0 transform scale-90"
                             x-transition:enter-end="opacity-100 transform scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                            style="display:none">



                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="block px-4 py-2 text-sm text-gray-700" type="submit">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Search for phones -->
                <div class="flex-1 min-w-0 px-12 lg:hidden">
                    <div class="max-w-xs w-full mx-auto">
                        <label for="desktop-search" class="sr-only">Search</label>
                        <div class="relative text-white focus-within:text-gray-600">
                            <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                                <!-- Heroicon name: solid/search -->
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                     fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0
                                    1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input id="desktop-search" class="block w-full bg-white bg-opacity-20 py-2 pl-10 pr-3
                            border border-transparent rounded-md leading-5 text-gray-900 placeholder-white
                            focus:outline-none focus:bg-opacity-100 focus:border-transparent focus:placeholder-gray-500
                            focus:ring-0 sm:text-sm" placeholder="Search" type="search" name="searches">
                        </div>
                    </div>
                </div>

                <!-- Menu button -->
                <div class="absolute right-0 flex-shrink-0 lg:hidden">
                    <!-- Mobile menu button -->
                    <button @click="openMobile = true" type="button" class="bg-transparent p-2 rounded-md inline-flex items-center justify-center text-indigo-200 hover:text-white hover:bg-white hover:bg-opacity-10 focus:outline-none focus:ring-2 focus:ring-white" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!--
                          Heroicon name: outline/menu

                          Menu open: "hidden", Menu closed: "block"
                        -->
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!--
                          Heroicon name: outline/x

                          Menu open: "block", Menu closed: "hidden"
                        -->
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="hidden lg:block border-t border-white border-opacity-20 py-5">
                <div class="grid grid-cols-3 gap-8 items-center">
                    <div class="col-span-2">
                        <nav class="flex space-x-4">
                            <!-- Current: "text-white", Default: "text-indigo-100" -->
                            @role('organization admin')
                            <a href="{{ route('dashboard')  }}" class="text-white text-sm font-medium rounded-md bg-white bg-opacity-0 px-3 py-2 hover:bg-opacity-10" aria-current="page"> Dashboard </a>
                            @endrole
                            @if(auth()->user()->hasRole('regular user|subscriber'))
                            <a href="{{ route('home')  }}" class="text-white text-sm font-medium rounded-md bg-white bg-opacity-0 px-3 py-2 hover:bg-opacity-10" aria-current="page"> Archives </a>
                            @endif
                            @role('organization admin')
                            <a href="#" class="text-indigo-100 text-sm font-medium rounded-md bg-white bg-opacity-0 px-3 py-2 hover:bg-opacity-10"> Archives </a>

                            <a href="{{ route('organizations.show', auth()->user()->organization)  }}" class="text-indigo-100 text-sm font-medium rounded-md bg-white bg-opacity-0 px-3 py-2 hover:bg-opacity-10"> Organization </a>

                            <a href="{{ route('organizations.users.associations', auth()->user()->organization)  }}" class="text-indigo-100 text-sm font-medium rounded-md bg-white bg-opacity-0 px-3 py-2 hover:bg-opacity-10"> Users Requests </a>
                            @endrole
                            @if(auth()->user()->hasRole('emiweb admin|emiweb staff'))
                            <a href="/emiweb" class="text-indigo-100 text-sm font-medium rounded-md bg-white bg-opacity-0 px-3 py-2 hover:bg-opacity-10"> Administrator </a>
                            @endif
                            @if(auth()->user()->hasRole('super admin'))
                                <a href="/admin" class="text-indigo-100 text-sm font-medium rounded-md bg-white bg-opacity-0 px-3 py-2 hover:bg-opacity-10"> Administrator </a>
                            @endif
                        </nav>
                    </div>
                    <div>
                        <div class="max-w-md w-full mx-auto flex justify-end"   x-data="{ openSearch: false }">
                            <svg @click="openSearch = true; $nextTick(() => $refs.input.focus())" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white " fill="none"
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
                                <!--
                                  Background overlay, show/hide based on modal state.

                                  Entering: "ease-out duration-300"
                                    From: "opacity-0"
                                    To: "opacity-100"
                                  Leaving: "ease-in duration-200"
                                    From: "opacity-100"
                                    To: "opacity-0"
                                -->
                                <div  class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity" aria-hidden="true"></div>

                                <!--
                                  Command palette, show/hide based on modal state.

                                  Entering: "ease-out duration-300"
                                    From: "opacity-0 scale-95"
                                    To: "opacity-100 scale-100"
                                  Leaving: "ease-in duration-200"
                                    From: "opacity-100 scale-100"
                                    To: "opacity-0 opacity-100 scale-100""
                                -->
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

{{--                                            {!! Form::open() !!}--}}
                                            {!! Form::open(['route' => 'records.search'])  !!}
                                        <input x-ref="input" name="search" type="text" class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm"
                                               placeholder="Search..."  aria-expanded="false"
                                               aria-controls="options">
                                        <input type="submit" hidden />
                                        {!! Form::close() !!}
                                    </div>



                                </div>
                            </div>


{{--                            <label for="mobile-search" class="sr-only">Search</label>--}}
{{--                            <div class="relative text-white focus-within:text-gray-600">--}}
{{--                                <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">--}}
{{--                                    <!-- Heroicon name: solid/search -->--}}
{{--                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">--}}
{{--                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />--}}
{{--                                    </svg>--}}
{{--                                </div>--}}
{{--                                <input id="mobile-search" class="block w-full bg-white bg-opacity-20 py-2 pl-10 pr-3--}}
{{--                                border border-transparent rounded-md leading-5 text-gray-900 placeholder-white--}}
{{--                                focus:outline-none focus:bg-opacity-100 focus:border-transparent--}}
{{--                                focus:placeholder-gray-500 focus:ring-0 sm:text-sm" placeholder="Search desktop" type="search"--}}
{{--                                       name="search">--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu, show/hide based on mobile menu state. -->
        <div class="lg:hidden" x-show="openMobile"
             x-transition:enter="duration-150 ease-out"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="duration-150 ease-in"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none">
            <!--
              Mobile menu overlay, show/hide based on mobile menu state.

              Entering: "duration-150 ease-out"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "duration-150 ease-in"
                From: "opacity-100"
                To: "opacity-0"
            -->
            <div class="z-20 fixed inset-0 bg-black bg-opacity-25" aria-hidden="true"></div>

            <!--
              Mobile menu, show/hide based on mobile menu state.

              Entering: "duration-150 ease-out"
                From: "opacity-0 scale-95"
                To: "opacity-100 scale-100"
              Leaving: "duration-150 ease-in"
                From: "opacity-100 scale-100"
                To: "opacity-0 scale-95"
            -->
            <div @click.away="openMobile = false"  class="z-30 absolute top-0 inset-x-0 max-w-3xl mx-auto w-full p-2 transition transform origin-top">
                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y divide-gray-200">
                    <div class="pt-3 pb-2">
                        <div class="flex items-center justify-between px-4">
                            <div>
                                <img class="h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-indigo-600.svg" alt="Workflow">
                            </div>
                            <div class="-mr-2">
                                <button @click="openMobile = false" type="button" class="bg-white rounded-md p-2 inline-flex items-center
                                justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none
                                focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                    <span class="sr-only">Close menu</span>
                                    <!-- Heroicon name: outline/x -->
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mt-3 px-2 space-y-1">

                            <a href="#" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800"> Dashboard </a>

                            <a href="#" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800"> Archives </a>

                            <a href="#" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800"> Organization </a>

                            <a href="#" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800"> Users Requests </a>
                            @if(auth()->user()->hasRole('emiweb admin|emiweb staff'))
                                <a href="/emiweb" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800"> Administrator </a>
                            @endif
                            @if(auth()->user()->hasRole('super admin'))
                                <a href="/admin" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800"> Administrator </a>
                            @endif


                        </div>
                    </div>
                    <div class="pt-4 pb-2">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
                            </div>
                            <div class="ml-3 min-w-0 flex-1">
                                <div class="text-base font-medium text-gray-800 truncate">{{ auth()->user()->name }}</div>
                                <div class="text-sm font-medium text-gray-500 truncate">{{ auth()->user()->email }}</div>
                            </div>

                        </div>
                        <div class="mt-3 px-2 space-y-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800" type="submit">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="-mt-24 pb-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <x-flash-message></x-flash-message>
            </div>
            <h1 class="sr-only">Page title</h1>
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
