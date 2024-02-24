<nav class="flex-1 px-2 pb-4 space-y-1">
    <!-- Current: "bg-indigo-800 text-white", Default: "text-indigo-100 hover:bg-indigo-600" -->
    @hasanyrole('super admin')


    <a href="{{ route('admin.users.index') }}" class="
            {{  (request()->is('admin/users*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/inbox -->
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        {{ __('Users') }}
    </a>


    <a href="{{ route('admin.categories.index') }}" class=" {{  (request()->is('admin/categories*')) ? 'bg-indigo-800' : ''  }}  text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/folder -->


        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
        </svg>
        {{ __('Categories') }}
    </a>
    <a href="{{ route('home') }}" class="text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/folder -->

        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        {{ __('Archives') }}
    </a>

    <a href="{{ route('admin.organizations.index') }}" class="{{  (request()->is('admin/organizations*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/calendar -->
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
        </svg>
        {{ __('Organizations') }}
    </a>

    <a href="{{ route('admin.roles.index') }}" class="{{  (request()->is('admin/roles*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/chart-bar -->
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
        </svg>
        {{ __('Roles') }}
    </a>

    <a href=" {{ route('admin.permissions.index') }} " class="{{  (request()->is('admin/permissions*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/chart-bar -->
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
        </svg>
        {{ __('Permissions') }}
    </a>

    <a href="{{ route('emiweb.users.subscribers') }}" class="{{  (request()->is('emiweb/users*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/inbox -->

        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
        </svg>
        {{ __('Subscriptions') }}
    </a>
    <a href="{{ route('admin.news.index') }}" class="{{  (request()->is('admin/news*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/inbox -->

        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14h2v-2h-2zm0-4h2V7h-2z" />
        </svg>
        {{ __('News') }}
    </a>

    @endhasanyrole

    @hasanyrole('emiweb admin|emiweb staff')

    <a href="{{ route('emiweb.users.index') }}" class="{{  (request()->is('emiweb/users*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/inbox -->
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        {{ __('Users') }}
    </a>


    <a href="{{ route('emiweb.categories.index') }}" class="{{  (request()->is('emiweb/categories*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/folder -->


        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
        </svg>
        {{ __('Categories') }}
    </a>
    <a href="{{ route('emiweb.archives.index') }}" class="{{  (request()->is('emiweb/archives*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/folder -->

        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
        {{ __('Archives') }}
    </a>

    <a href="{{ route('emiweb.organizations.index') }}" class="{{  (request()->is('emiweb/organizations*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/calendar -->
        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
        </svg>
        {{ __('Organizations') }}
    </a>

    <a href="{{ route('emiweb.users.subscribers') }}" class="{{  (request()->is('emiweb/users*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/inbox -->

        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
        </svg>
        {{ __('Subscriptions') }}
    </a>

    <a href="{{ route('admin.news.index') }}" class="{{  (request()->is('admin/news*')) ? 'bg-indigo-800' : ''  }}  text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/inbox -->

        <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14h2v-2h-2zm0-4h2V7h-2z" />
        </svg>
        {{ __('News') }}
    </a>

    @endhasanyrole

    <a href="#" class=" text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
        <!-- Heroicon name: outline/log off -->
        <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" viewBox="0 0 512 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
            <path style="fill: rgb(165 180 252 / var(--tw-text-opacity));" d="M288 32c0-17.7-14.3-32-32-32s-32 14.3-32 32V256c0 17.7 14.3 32 32 32s32-14.3 32-32V32zM143.5 120.6c13.6-11.3 15.4-31.5 4.1-45.1s-31.5-15.4-45.1-4.1C49.7 115.4 16 181.8 16 256c0 132.5 107.5 240 240 240s240-107.5 240-240c0-74.2-33.8-140.6-86.6-184.6c-13.6-11.3-33.8-9.4-45.1 4.1s-9.4 33.8 4.1 45.1c38.9 32.3 63.5 81 63.5 135.4c0 97.2-78.8 176-176 176s-176-78.8-176-176c0-54.4 24.7-103.1 63.5-135.4z" />
        </svg>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="block font-medium" type="submit">{{ __('Logout') }}</button>
        </form>
    </a>

</nav>