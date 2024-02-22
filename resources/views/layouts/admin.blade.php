<!doctype html>
<html class="h-full bg-gray-100 scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.lordicon.com/lusqsztk.js"></script>
</head>

<body class="h-full h-full">
    <div>
        <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        <div id="MainMenu" class="fixed inset-0 flex z-40 md:hidden" role="dialog" style="display:none" aria-modal="true">
            <!--
          Off-canvas menu overlay, show/hide based on off-canvas menu state.

          Entering: "transition-opacity ease-linear duration-300"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "transition-opacity ease-linear duration-300"
            From: "opacity-100"
            To: "opacity-0"
        -->
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>

            <!--
          Off-canvas menu, show/hide based on off-canvas menu state.

          Entering: "transition ease-in-out duration-300 transform"
            From: "-translate-x-full"
            To: "translate-x-0"
          Leaving: "transition ease-in-out duration-300 transform"
            From: "translate-x-0"
            To: "-translate-x-full"
        -->
            <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-indigo-700">
                <!--
              Close button, show/hide based on off-canvas menu state.

              Entering: "ease-in-out duration-300"
                From: "opacity-0"
                To: "opacity-100"
              Leaving: "ease-in-out duration-300"
                From: "opacity-100"
                To: "opacity-0"
            -->
                <div class="absolute top-0 right-0 -mr-12 pt-2">
                    <button onclick="toggleMainMenu()" type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
                        <span class="sr-only">Close sidebar</span>
                        <!-- Heroicon name: outline/x -->
                        <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="flex-shrink-0 flex items-center px-4 text-white">
                    EMIWEB
                </div>
                <div class="mt-5 flex-1 h-0 overflow-y-auto">
                    <x-main-menu></x-main-menu>
                </div>
            </div>

            <div class="flex-shrink-0 w-14" aria-hidden="true">
                <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
            <!-- Sidebar component, swap this element with another sidebar if you like -->
            <div class="flex flex-col flex-grow pt-5 bg-indigo-700 overflow-y-auto">
                <div class="flex items-center flex-shrink-0 px-4 text-white font-bold">
                    EMIWEB
                </div>
                <div class="mt-5 flex-1 flex flex-col">
                    <x-main-menu></x-main-menu>
                </div>
            </div>
        </div>
        <div class="md:pl-64 flex flex-col flex-1">
            <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow sm:px-6 md:px-8">
                <div class="max-w-7xl flex  w-[100%] mx-auto md:py-3 sm:py-1  px-4 sm:px-6 md:px-8">
                    <button onclick="toggleMainMenu()" type="button" class="px-4 border-r  border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                        <span class="sr-only">{{ __('Open sidebar') }}</span>
                        <!-- Heroicon name: outline/menu-alt-2 -->
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                        </svg>
                    </button>
                    <div class="flex-1 px-4 flex justify-end">

                        <div class="ml-4 flex items-center md:ml-6">
                            <!-- Profile dropdown -->
                            <div class="ml-3 relative -mr-4">
                                <div>
                                    <button onclick="toggleProfileMenu()" type="button" class=" md:mt-0 inline-flex w-full items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <svg class="h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                                        </svg>
                                        {{ __('Menu') }}
                                    </button>
                                </div>

                                <div id="profileMenu" style="display: none; width:300px;" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none transition ease-out duration-100 ease-in duration-75" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <!-- Active: "bg-gray-100", Not Active: "" -->
                                    <div class="flex block px-4 py-2 text-sm text-gray-700 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class=" pr-4" height="32" width="32" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                            <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z" />
                                        </svg>
                                        <span class="block text-sm text-gray-700 font-normal" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                            {{ auth()->user()->name }}</span>
                                    </div>
                                    <div class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-700  group ">

                                        <a href="/home" class="block text-sm text-gray-700 flex  items-center font-bold" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:fill-white pr-4" height="18" width="32" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M64 464c-8.8 0-16-7.2-16-16V64c0-8.8 7.2-16 16-16H224v80c0 17.7 14.3 32 32 32h80V448c0 8.8-7.2 16-16 16H64zM64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V154.5c0-17-6.7-33.3-18.7-45.3L274.7 18.7C262.7 6.7 246.5 0 229.5 0H64zm56 256c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120zm0 96c-13.3 0-24 10.7-24 24s10.7 24 24 24H264c13.3 0 24-10.7 24-24s-10.7-24-24-24H120z" />
                                            </svg>
                                            <span class="group-hover:text-white">{{ __('Home') }}</span></a>
                                    </div>
                                    <div class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-700  group ">
                                        <a href="/news/" class="block text-sm text-gray-700 flex  items-center font-bold" role="menuitem" tabindex="-1" id="user-menu-item-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="group-hover:fill-white pr-4" height="32" width="32" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                <path d="M96 96c0-35.3 28.7-64 64-64H448c35.3 0 64 28.7 64 64V416c0 35.3-28.7 64-64 64H80c-44.2 0-80-35.8-80-80V128c0-17.7 14.3-32 32-32s32 14.3 32 32V400c0 8.8 7.2 16 16 16s16-7.2 16-16V96zm64 24v80c0 13.3 10.7 24 24 24H296c13.3 0 24-10.7 24-24V120c0-13.3-10.7-24-24-24H184c-13.3 0-24 10.7-24 24zm208-8c0 8.8 7.2 16 16 16h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H384c-8.8 0-16 7.2-16 16zm0 96c0 8.8 7.2 16 16 16h48c8.8 0 16-7.2 16-16s-7.2-16-16-16H384c-8.8 0-16 7.2-16 16zM160 304c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16zm0 96c0 8.8 7.2 16 16 16H432c8.8 0 16-7.2 16-16s-7.2-16-16-16H176c-8.8 0-16 7.2-16 16z" />
                                            </svg>
                                            <span class="group-hover:text-white">{{ __('News') }}</span></a>
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
                        </div>
                    </div>
                </div>
            </div>



            <main>
                <div class="py-6">
                    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                        <x-flash-message></x-flash-message>
                    </div>
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                        <!-- Replace with your content -->

                        {{ $slot }}

                        <!-- /End replace -->
                    </div>
                </div>
            </main>
        </div>
    </div>



</body>
<script>
    function toggleProfileMenu() {
        var profileMenu = document.getElementById("profileMenu");
        if (profileMenu.style.display === "none") {
            profileMenu.style.display = "block";
        } else {
            profileMenu.style.display = "none";
        }
    }
    // function flashClose() {
    //        var flashBox = document.getElementById('flashBox')
    //         flashBox.remove();
    // }

    function toggleMainMenu() {
        var MainMenu = document.getElementById("MainMenu");
        if (MainMenu.style.display === "none") {
            MainMenu.style.removeProperty('display');
        } else {
            MainMenu.style.display = "none";
        }
    }
</script>
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
            ["show", "hide", "isVisible", "capture", "cancelCapture", "unload", "reload", "isExtensionInstalled", "setReporter", "setCustomData", "on", "off"].forEach(function(e) {
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

</html>