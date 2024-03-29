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

    <!-- Scripts -->
    <script src='https://www.google.com/recaptcha/api.js'></script>

    <style>

        .newSet{
            content: url('/images/sort-table.svg');
            width: 15px;
            height: 15px;
            display: inline-block;
            margin-top: 2px;
        }
        .sort-result-table::after {
            content: url('/images/sort-table.svg');
            width: 15px;
            height: 15px;
            display: inline-block;
            margin-top: 2px;

        }

    </style>

    <!-- Fathom - beautiful, simple website analytics -->
    <script src="https://cdn.usefathom.com/script.js" data-site="MAMOPBNC" defer></script>
    <!-- / Fathom -->

    <script>
window.addEventListener('load', (event) => {
  document.getElementById('global-search').addEventListener('click', () => {
    fathom.trackEvent('Global sökning');
  });
});
</script>

<script>
window.addEventListener('load', (event) => {
  document.getElementById('search-archive').addEventListener('click', () => {
    fathom.trackEvent('Arkivsökning');
  });
});
</script>


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

            <a href="{{ route('home.users.edit', auth()->user()->id ) }}"
               class="gap-x-1 px-4 py-1 bg-indigo-600 rounded-full text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-900">
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
            @if(auth()->user()->hasRole('regular user|subscriber|organizational subscriber'))
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
            @if(auth()->user()->hasRole('regular user|subscriber|organizational subscriber'))
            <div class="max-w-md w-full mx-auto flex justify-center" x-data="{ openSearch: false }">
                <div @click="openSearch = true; $nextTick(() => $refs.input.focus())" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4
                 font-medium rounded-full text-indigo-600 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2
                 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                        <button type="submit" x-bind:disabled="buttonDisable" id="global-search" class="items-center disabled:opacity-50 px-8 py-2 border
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
                        <li class="font-normal">
                            <a href="{{ route('home.users.edit', auth()->user()->id ) }}">
                                {{ __('Account') }}
                            </a>
                        </li>
                    @endif
                @endif
                <li class="pl-8">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">{{ __('Logout') }}</button>
                    </form>
                </li>
                <li class="font-normal pl-8">
                    <a href="https://www.emiweb.se">
                        {{ __('Back to Emiweb.se') }}
                    </a>
                </li>

            </ul>
        </div>
    </div>

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
</script>

<script>
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
</script>

<script>
    document.getElementById('qry_first_name').addEventListener('change', function() {
      const inputField = document.getElementById('first_name_value');
      if (this.value === 'exact') {
        inputField.setAttribute('required', 'required');
      } else {
        inputField.removeAttribute('required');
      }
    });
    </script>
<script>
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