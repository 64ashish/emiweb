<nav class="flex-1 px-2 pb-4 space-y-1">
    <!-- Current: "bg-indigo-800 text-white", Default: "text-indigo-100 hover:bg-indigo-600" -->
    @hasanyrole('super admin')
        <a href="{{ route('admin.users.index') }}" class="
                {{  (request()->is('admin/users*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/inbox -->
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Users
        </a>

        <a href="{{ route('admin.categories.index') }}" class=" {{  (request()->is('admin/categories*')) ? 'bg-indigo-800' : ''  }}  text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/folder -->
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
            </svg>
            Categories
        </a>

        <a href="{{ route('admin.archives.index') }}" class="{{  (request()->is('admin/archives*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/folder -->

            <svg xmlns="http://www.w3.org/2000/svg"  class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            Archives
        </a>

        <a href="{{ route('admin.organizations.index') }}"
           class="{{  (request()->is('admin/organizations*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/calendar -->
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
            </svg>
            Organizations
        </a>

        <a href="{{ route('admin.roles.index') }}" class="{{  (request()->is('admin/roles*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/chart-bar -->
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
            </svg>
            Roles
        </a>

        <a href=" {{ route('admin.permissions.index') }} " class="{{  (request()->is('admin/permissions*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/chart-bar -->
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
            Permissions
        </a>
        <a href=" {{ route('admin.statistics.index') }} " class="{{  (request()->is('admin/statistics*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/chart-bar -->
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" viewBox="0 0 64 64" fill="currentColor">
                <rect x="5" y="40" width="8" height="20" />
                <rect x="19" y="28" width="8" height="32" />
                <rect x="33" y="40" width="8" height="20" />
                <rect x="47" y="28" width="8" height="32" />
                <path d="M4 30 L24 13 L36 29 L58 15" stroke="currentColor" stroke-width="4" fill="none"/>
            </svg>
            User Statistics
        </a>
    @endhasanyrole

    @hasanyrole('emiweb admin|emiweb staff')

        <a href="{{ route('emiweb.users.index') }}" class="{{  (request()->is('emiweb/users*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/inbox -->
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            Users
        </a>

        <a href="{{ route('emiweb.categories.index') }}" class="{{  (request()->is('emiweb/categories*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/folder -->


            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
            </svg>
            Categories
        </a>
        <a href="{{ route('emiweb.archives.index') }}" class="{{  (request()->is('emiweb/archives*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/folder -->

            <svg xmlns="http://www.w3.org/2000/svg"  class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            Archives
        </a>

        <a href="{{ route('emiweb.organizations.index') }}"
           class="{{  (request()->is('emiweb/organizations*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/calendar -->
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
            </svg>
            Organizations
        </a>

        <a href="{{ route('emiweb.users.subscribers') }}" class="{{  (request()->is('emiweb/users*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/inbox -->

            <svg xmlns="http://www.w3.org/2000/svg"  class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
            </svg>
            Subscriptions
        </a>

        <a href=" {{ route('emiweb.statistics.index') }} " class="{{  (request()->is('emiweb/statistics*')) ? 'bg-indigo-800' : ''  }} text-indigo-100 hover:bg-indigo-600 group flex items-center px-2 py-2 text-sm font-medium rounded-md">
            <!-- Heroicon name: outline/chart-bar -->
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-3 flex-shrink-0 h-6 w-6 text-indigo-300" viewBox="0 0 64 64" fill="currentColor">
                <rect x="5" y="40" width="8" height="20" />
                <rect x="19" y="28" width="8" height="32" />
                <rect x="33" y="40" width="8" height="20" />
                <rect x="47" y="28" width="8" height="32" />
                <path d="M4 30 L24 13 L36 29 L58 15" stroke="currentColor" stroke-width="4" fill="none"/>
            </svg>
            User Statistics
        </a>
    @endhasanyrole
</nav>
