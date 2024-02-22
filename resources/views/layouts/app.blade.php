<!doctype html>
<html class="h-full bg-gray-100 scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
    <script src="https://cdn.lordicon.com/lusqsztk.js"></script>

    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://js.stripe.com/v3/"></script>

    <style>
        .sort-result-table::after {
            content: url('/images/sort-table.svg');
            width: 15px;
            height: 15px;
            display: inline-block;
            margin-top: 2px;

        }
    </style>


</head>

<body class="h-full">
    <div class="min-h-full">
        @if(auth()->user()->hasRole('regular user'))
        <div>
            <div class="p-5 bg-white text-sm font-semibold flex justify-center items-center gap-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                </svg>
                <span>
                    {{ __('Subscribe to get full access to all archives. Starting at 200 SEK / 3 months.') }}
                </span>

                <a href="{{ route('home.users.edit', auth()->user()->id ) }}" class="gap-x-1 px-4 py-1 bg-indigo-600 rounded-full text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-900">
                    {{ __('Start subscription') }}
                </a>
            </div>
        </div>
        @endif


        <header class="pb-5 pt-5 {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }}   ">

            {{-- for desktop--}}
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8 flex justify-between">
                <div class="flex items-center">
                    @if(auth()->user()->hasRole('organization admin|organization staff'))
                    <a href="{{ route('dashboard')  }}" aria-current="page">
                        <img src="/images/emiweb-w.svg" class="hidden lg:inline-block	h-5">
                        <img src="/images/emiweb-mobile-logo.png" class=" lg:hidden">
                    </a>
                    @endif
                    @if(auth()->user()->hasRole('regular user|subscriber|organizational subscriber|admin|super admin'))
                    <a href="{{ route('home')  }}" aria-current="page">
                        <img src="/images/emiweb-w.svg" class="hidden lg:inline-block	h-5">
                        <img src="/images/emiweb-mobile-logo.png" class=" lg:hidden">
                    </a>
                    @endif
                    {!! Form::open([ 'route'=>['local', http_build_query(request()->except(['_token']))] ]) !!}
                    <ul class="pl-16 text-white font-bold inline-flex">
                        <li><button name="language" value="sv" type="submit">Svenska</button> /</li>
                        <li class="px-1"><button name="language" value="en" type="submit">English</button> </li>
                    </ul>
                    {!! Form::close() !!}
                </div>
                <div class="flex w-1/2 {{ auth()->user()->hasRole('regular user|subscriber|organizational subscriber') ?? 'justify-end' }}">
                    @if(auth()->user()->hasRole('regular user|subscriber|organizational subscriber|admin|super admin'))
                    <div class="max-w-md w-full mx-auto flex justify-center" x-data="{ openSearch: false }">
                        <div @click="openSearch = true; $nextTick(() => $refs.input.focus())" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4
                 font-medium rounded-full text-indigo-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2
                 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span class="text-indigo-600 font-normal	">{{ __('Search in all archives') }}</span>
                        </div>
                        {{-- search starts from here --}}

                        <div x-show="openSearch" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-20 overflow-y-auto p-4 sm:p-6 md:p-20" role="dialog" aria-modal="true" style="display:none">

                            <div class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity" aria-hidden="true"></div>

                            <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 opacity-100 scale-100" class="mx-auto max-w-xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
                                <div>
                                    <div class="relative" @click.away="openSearch = false" x-data="{ reveal: false,
                             buttonDisable:true,
                             f:null, l:null, y:null, p:null }">
                                        <!-- Heroicon name: solid/search -->
                                        <form action="{{ route('search') }}" method="POST" x-on:submit="reveal = true;buttonDisable=true ">
                                            @csrf

                                            <div class="flex items-center flex-wrap p-5">

                                                <label class="w-1/3 border-0 bg-transparent pl-5 pr-11 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm" aria-expanded="false" aria-controls="options">{{ __('First name') }}</label>
                                                <input x-ref="input" x-model="f" x-on:input="[(f?.length != 0 || l?.length !=0 || y?.length !=0 || p?.length !=0) ? buttonDisable = false : buttonDisable = true]" name="qry_first_name" type="text" class="h-12 w-2/3 border-0 border-b-2 bg-transparent pl-5 pr-2 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm" placeholder="{{ __('First name') }}..." aria-expanded="false" aria-controls="options">


                                                <label class="w-1/3 border-0 bg-transparent pl-5 pr-11 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm" aria-expanded="false" aria-controls="options">{{ __('Last name') }}</label>
                                                <input x-ref="input" name="qry_last_name" type="text" x-model="l" x-on:input="[(f?.length != 0 || l?.length !=0 || y?.length !=0 || p?.length !=0) ? buttonDisable = false : buttonDisable = true]" class="h-12 w-2/3 border-0 border-b-2 bg-transparent pl-5 pr-42 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm" placeholder="{{ __('Last name') }}..." aria-expanded="false" aria-controls="options">


                                                <label class="w-1/3 border-0 bg-transparent pl-5 pr-11 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm" aria-expanded="false" aria-controls="options">{{ __('Född år') }}</label>
                                                <input x-ref="input" name="year" type="text" x-model="y" x-on:input="[(f?.length != 0 || l?.length !=0 || y?.length !=0 || p?.length !=0) ? buttonDisable = false : buttonDisable = true]" class="h-12 w-2/3 border-0 border-b-2 bg-transparent pl-5 pr-2 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm" size="20" maxlength="4" placeholder="{{ __('Född år') }}..." aria-expanded="false" aria-controls="options">

                                                <label class="w-1/3 border-0 bg-transparent pl-5 pr-11 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm" aria-expanded="false" aria-controls="options">{{ __('Född församling') }}</label>
                                                <input x-ref="input" name="parish" type="text" x-model="p" x-on:input="[(f?.length != 0 || l?.length !=0 || y?.length !=0 || p?.length !=0) ? buttonDisable = false : buttonDisable = true]" class="h-12 w-2/3 border-0 border-b-2 bg-transparent pl-5 pr-2 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm" placeholder="{{ __('Född församling') }}..." aria-expanded="false" aria-controls="options">



                                            </div>
                                            <div class="p-5 flex justify-end">
                                                <button type="submit" x-bind:disabled="buttonDisable" class="items-center disabled:opacity-50 px-8 py-2 border
                                border-transparent text-base font-medium rounded-md shadow-sm text-white
                                 bg-indigo-600  hover:bg-indigo-700 focus:outline-none focus:ring-2
                                focus:ring-offset-2 focus:ring-indigo-500 flex">

                                                    <div class="flex" x-show="reveal">
                                                        <div>
                                                            <lord-icon src="{{ asset('lordie/search-loader-white.json') }}" trigger="loop" colors="primary:#ffffff" style="width:30px;height:30px">
                                                            </lord-icon>
                                                        </div>

                                                    </div>
                                                    {{ __('Search') }}
                                                </button>
                                            </div>


                                        </form>
                                        <div class="p-5 flex" x-show="reveal">
                                            <div>
                                                <lord-icon src="{{ asset('lordie/search-loader.json') }}" trigger="loop" colors="primary:#166534" style="width:30px;height:30px">
                                                </lord-icon>
                                            </div>
                                            <p>{{ __("We're currently searching through over 8 million records, hang on!") }}</p>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif
                    <ul class="font-bold inline-flex items-center text-white shrink-0">

                        @if(auth()->user()->hasRole('regular user|subscriber'))
                        @if(!Session::has('auto login'))
                        <li class="pl-8">
                            <div class="ml-3 relative">
                                <div>
                                    <button onclick="toggleProfileMenu()" type="button" class=" md:mt-0 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-1" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                        </svg>
                                        {{ __('Account') }}
                                    </button>
                                </div>

                                <div id="profileMenu" style="display: none; width:300px;" class="origin-top-right absolute right-0 mt-2  rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none
                               transition ease-out duration-100 ease-in duration-75" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <!-- Active: "bg-gray-100", Not Active: "" -->
                                    <div class="flex block px-4 py-2 text-sm text-gray-700 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class=" pr-4" height="32" width="32" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                        </svg>
                                        <span class="block text-sm text-gray-700 font-normal" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                            {{ auth()->user()->name }}</span>
                                    </div>
                                    <div class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-700  group ">
                                        <a class="block text-sm text-gray-700 flex  items-center" role="menuitem" tabindex="-1" id="user-menu-item-0" href="{{ route('home.users.edit', auth()->user()->id ) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:fill-white pr-4" height="32" width="32" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M0 128C0 92.7 28.7 64 64 64H448c35.3 0 64 28.7 64 64V384c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V128zm64 32v64c0 17.7 14.3 32 32 32H416c17.7 0 32-14.3 32-32V160c0-17.7-14.3-32-32-32H96c-17.7 0-32 14.3-32 32zM80 320c-13.3 0-24 10.7-24 24s10.7 24 24 24h56c13.3 0 24-10.7 24-24s-10.7-24-24-24H80zm136 0c-13.3 0-24 10.7-24 24s10.7 24 24 24h48c13.3 0 24-10.7 24-24s-10.7-24-24-24H216z" />
                                            </svg>
                                            <span class="group-hover:text-white">{{ __('Account') }}</span></a>
                                    </div>
                                    <div class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-700  group ">
                                        <a class="block text-sm text-gray-700 flex  items-center" role="menuitem" tabindex="-1" id="user-menu-item-0" href="{{ route('home.users.edit', auth()->user()->id ) }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:fill-white pr-4" height="32" width="32" viewBox="0 0 576 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M0 128C0 92.7 28.7 64 64 64H512c35.3 0 64 28.7 64 64v64c0 8.8-7.4 15.7-15.7 18.6C541.5 217.1 528 235 528 256s13.5 38.9 32.3 45.4c8.3 2.9 15.7 9.8 15.7 18.6v64c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V320c0-8.8 7.4-15.7 15.7-18.6C34.5 294.9 48 277 48 256s-13.5-38.9-32.3-45.4C7.4 207.7 0 200.8 0 192V128z" />
                                            </svg>
                                            <span class="group-hover:text-white">{{ __('My subscription') }}</span></a>
                                    </div>
                                    <div class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-700  group ">
                                        <a href="/news/" class="block text-sm text-gray-700 flex  items-center" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:fill-white pr-4" height="32" width="32" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M96 96c0-35.3 28.7-64 64-64H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H80c-44.2 0-80-35.8-80-80V128c0-17.7 14.3-32 32-32s32 14.3 32 32V400c0 8.8 7.2 16 16 16s16-7.2 16-16V96zm64 24v80c0 13.3 10.7 24 24 24H296c13.3 0 24-10.7 24-24V120c0-13.3-10.7-24-24-24H184c-13.3 0-24 10.7-24 24zm208-8c0 8.8 7.2 16 16 16h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H384c-8.8 0-16 7.2-16 16zm0 96c0 8.8 7.2 16 16 16h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H384c-8.8 0-16 7.2-16 16zM160 304c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16zm0 96c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16z" />
                                            </svg>
                                            <span class="group-hover:text-white">{{ __('News') }}
                                                @if (!Session::get('user_has_seen_latest_news'))
                                                <span class="text-red-500">&#x1F534;</span> 
                                                @endif</span></a>
                                    </div>
                                    <div class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-700 group ">
                                        <a href="https://www.emiweb.se" class="block text-sm text-gray-700 flex  items-center  font-bold" role="menuitem" tabindex="-1" id="user-menu-item-0">

                                            <svg xmlns="http://www.w3.org/2000/svg" class=" pr-4 group-hover:fill-white" height="32" width="32" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M352 0c-12.9 0-24.6 7.8-29.6 19.8s-2.2 25.7 6.9 34.9L370.7 96 201.4 265.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L416 141.3l41.4 41.4c9.2 9.2 22.9 11.9 34.9 6.9s19.8-16.6 19.8-29.6V32c0-17.7-14.3-32-32-32H352zM80 32C35.8 32 0 67.8 0 112V432c0 44.2 35.8 80 80 80H400c44.2 0 80-35.8 80-80V320c0-17.7-14.3-32-32-32s-32 14.3-32 32V432c0 8.8-7.2 16-16 16H80c-8.8 0-16-7.2-16-16V112c0-8.8 7.2-16 16-16H192c17.7 0 32-14.3 32-32s-14.3-32-32-32H80z" />
                                            </svg>
                                            <span class="group-hover:text-white">{{ __('Back to Emiweb.se') }}</span>
                                        </a>
                                    </div>

                                    <form class=" border-gray-200 border-t gruop  " method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="block px-4 mt-1 py-2 text-sm w-full text-gray-700 flex items-center font-bold hover:bg-indigo-700 group" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class=" pr-4 group-hover:fill-white" height="32" width="32" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V256c0 17.7 14.3 32 32 32s32-14.3 32-32V32zM143.5 120.6c13.6-11.3 15.4-31.5 4.1-45.1s-31.5-15.4-45.1-4.1C49.7 115.4 16 181.8 16 256c0 132.5 107.5 240 240 240s240-107.5 240-240c0-74.2-33.8-140.6-86.6-184.6c-13.6-11.3-33.8-9.4-45.1 4.1s-9.4 33.8 4.1 45.1c38.9 32.3 63.5 81 63.5 135.4c0 97.2-78.8 176-176 176s-176-78.8-176-176c0-54.4 24.7-103.1 63.5-135.4z" />
                                            </svg>
                                            <span class="group-hover:text-white">{{ __('Logout') }}</span></button>
                                    </form>
                                </div>
                            </div>

                        </li>
                        @endif
                        @endif

                        @if(auth()->user()->hasRole('admin|super admin'))
                        <!-- Profile dropdown -->
                        <li class="pl-8">
                            <div class="ml-3 relative">
                                <div>
                                    <button onclick="toggleProfileMenu()" type="button" class=" md:mt-0 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-1" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                        </svg>
                                        {{ __('Menu') }}
                                    </button>
                                </div>

                                <div id="profileMenu" style="display: none; width:300px;" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none
                               transition ease-out duration-100 ease-in duration-75" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <!-- Active: "bg-gray-100", Not Active: "" -->
                                    <div class="flex block px-4 py-2 text-sm text-gray-700 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class=" pr-4" height="32" width="32" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                        </svg>
                                        <span class="block text-sm text-gray-700 font-normal" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                            {{ auth()->user()->name }}</span>
                                    </div>
                                    <div class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-700  group ">
                                        <a href="/admin/users" class="block text-sm text-gray-700 flex  items-center" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:fill-white pr-4" height="18" width="32" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z" />
                                            </svg>
                                            <span class="group-hover:text-white">{{ __('Dashboard') }}</span></a>
                                    </div>

                                    <div class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-700  group ">
                                        <a href="/news/" class="block text-sm text-gray-700 flex  items-center" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:fill-white pr-4" height="32" width="32" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M96 96c0-35.3 28.7-64 64-64H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H80c-44.2 0-80-35.8-80-80V128c0-17.7 14.3-32 32-32s32 14.3 32 32V400c0 8.8 7.2 16 16 16s16-7.2 16-16V96zm64 24v80c0 13.3 10.7 24 24 24H296c13.3 0 24-10.7 24-24V120c0-13.3-10.7-24-24-24H184c-13.3 0-24 10.7-24 24zm208-8c0 8.8 7.2 16 16 16h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H384c-8.8 0-16 7.2-16 16zm0 96c0 8.8 7.2 16 16 16h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H384c-8.8 0-16 7.2-16 16zM160 304c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16zm0 96c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16z" />
                                            </svg>
                                            <span class="group-hover:text-white">{{ __('News') }}
                                                @if (!Session::get('user_has_seen_latest_news'))
                                                <span class="text-red-500">&#x1F534;</span>
                                                @endif</span></a>
                                    </div>
                                    
                                    <form class=" border-gray-200 border-t gruop  " method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="block px-4 mt-1 py-2 text-sm w-full text-gray-700 flex items-center font-bold hover:bg-indigo-700 group" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class=" pr-4 group-hover:fill-white" height="32" width="32" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V256c0 17.7 14.3 32 32 32s32-14.3 32-32V32zM143.5 120.6c13.6-11.3 15.4-31.5 4.1-45.1s-31.5-15.4-45.1-4.1C49.7 115.4 16 181.8 16 256c0 132.5 107.5 240 240 240s240-107.5 240-240c0-74.2-33.8-140.6-86.6-184.6c-13.6-11.3-33.8-9.4-45.1 4.1s-9.4 33.8 4.1 45.1c38.9 32.3 63.5 81 63.5 135.4c0 97.2-78.8 176-176 176s-176-78.8-176-176c0-54.4 24.7-103.1 63.5-135.4z" />
                                            </svg>
                                            <span class="group-hover:text-white">{{ __('Logout') }}</span></button>
                                    </form>
                                </div>
                            </div>

                        </li>
                        @endif
                        @if(auth()->user()->hasRole('organizational subscriber'))
                        <li class="pl-8">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">{{ __('Logout') }}</button>
                            </form>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            <script>
                function toggleProfileMenu() {
                    var profileMenu = document.getElementById("profileMenu");
                    if (profileMenu.style.display === "none") {
                        profileMenu.style.display = "block";
                    } else {
                        profileMenu.style.display = "none";
                    }
                }
            </script>
            {{-- for mobile--}}

            <div>

            </div>

        </header>
        <main class=" pb-8">

            <div class="mx-auto px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    <x-flash-message></x-flash-message>
                </div>



                {{ $slot }}


            </div>

        </main>
        <footer>
            <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">
                <div class="border-t border-gray-200 py-8 text-sm text-gray-500 text-center sm:text-left"><span class="block sm:inline">{{ date("Y") }} Emiweb.</span> <span class="block sm:inline">All rights
                        reserved.</span></div>
            </div>
        </footer>
    </div>
    <script>
        function checkButton() {
            // return {
            //     buttonStatus:false,
            //
            // }
        }
    </script>
</body>
<script>
    window.markerConfig = {
        destination: '62be9bd71643fb2ce067dea4',
        source: 'snippet'
    };

    function toggleProfileMenu() {
        var profileMenu = document.getElementById("profileMenu");
        if (profileMenu.style.display === "none") {
            profileMenu.style.display = "block";
        } else {
            profileMenu.style.display = "none";
        }
    }

    function toggleMainMenu() {
        var MainMenu = document.getElementById("MainMenu");
        if (MainMenu.style.display === "none") {
            MainMenu.style.removeProperty('display');
        } else {
            MainMenu.style.display = "none";
        }
    }

    ! function(e, r, a) {
        if (!e.__Marker) {
            e.__Marker = {};
            var t = [],
                n = {
                    __cs: t
                };
            ["show", "hide", "isVisible", "capture", "cancelCapture", "unload", "reload", "isExtensionInstalled",
                "setReporter", "setCustomData", "on", "off"
            ].forEach(function(e) {
                n[e] = function() {
                    var r = Array.prototype.slice.call(arguments);
                    r.unshift(e), t.push(r)
                }
            }), e.Marker = n;
            var s = r.createElement("script");
            s.async = 1, s.src = "https://edge.marker.io/latest/shim.js";
            var i = r.getElementsByTagName("script")[0];
            i.parentNode.insertBefore(s, i)
        }
    }(window, document);

    document.getElementById('qry_first_name').addEventListener('change', function() {
        const inputField = document.getElementById('first_name_value');
        if (this.value === 'exact') {
            inputField.setAttribute('required', 'required');
        } else {
            inputField.removeAttribute('required');
        }
    });

    document.getElementById('qry_last_name').addEventListener('change', function() {
        const inputField = document.getElementById('last_name_value');
        if (this.value === 'exact') {
            inputField.setAttribute('required', 'required');
        } else {
            inputField.removeAttribute('required');
        }
    });
</script>

</html>