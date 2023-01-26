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
        <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
            <button onclick="toggleMainMenu()" type="button" class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden">
                <span class="sr-only">Open sidebar</span>
                <!-- Heroicon name: outline/menu-alt-2 -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
            <div class="flex-1 px-4 flex justify-end">

                <div class="ml-4 flex items-center md:ml-6">


                    <!-- Profile dropdown -->
                    <div class="ml-3 relative">
                        <div>
                            <button onclick="toggleProfileMenu()" type="button" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="{{ asset('images/profile.jpg') }}" >
                            </button>
                        </div>

                        <div id="profileMenu" style="display: none" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md
                        shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none
                               transition ease-out duration-100 ease-in duration-75" role="menu"
                             aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                            <!-- Active: "bg-gray-100", Not Active: "" -->
                            <span class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">{{ auth()->user()->name }}</span>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1"
                               id="user-menu-item-0">Update password</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="block px-4 py-2 text-sm text-gray-700" type="submit">Logout</button>
                            </form>
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

    function toggleMainMenu(){
        var MainMenu = document.getElementById("MainMenu");
        if (MainMenu.style.display ==="none") {
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
!function(e,r,a){if(!e.__Marker){e.__Marker={};var t=[],n={__cs:t};["show","hide","isVisible","capture","cancelCapture","unload","reload","isExtensionInstalled","setReporter","setCustomData","on","off"].forEach(function(e){n[e]=function(){var r=Array.prototype.slice.call(arguments);r.unshift(e),t.push(r)}}),e.Marker=n;var s=r.createElement("script");s.async=1,s.src="https://edge.marker.io/latest/shim.js";var i=r.getElementsByTagName("script")[0];i.parentNode.insertBefore(s,i)}}(window,document);
</script>
</html>
