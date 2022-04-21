<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
        <!-- Left column -->
        <div class="grid grid-cols-1 gap-4 lg:col-span-2">
            <section aria-labelledby="section-1-title">

                <div class="rounded-lg bg-white overflow-hidden shadow">
                    <div class="p-6">
                        <h2>
                            Archives List
                        </h2>
                        <ul role="list" class="divide-y divide-gray-200">
                        @foreach( $groups as $group => $places)
                            <li class="py-4 flex flex-col">
                                <p class="text-sm font-medium text-black-900">Category: {{ $group }}</p>
                                @foreach($places as $place => $archives)
                                    <p class="text-sm font-medium text-gray-900 pl-3">Places: {{ $place }}</p>
                                    <ul class="pl-6">
                                        @foreach($archives as $archive)
                                            <li class="py-1">
                                                <div class="flex items-center space-x-4">

                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $archive->name }}</p>
                                                        <p class="text-sm text-gray-500 truncate">Total records: xyz</p>
                                                    </div>
                                                    <div>
                                                        <a href="#" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50"> View </a>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                @endforeach
                            </li>
                        @endforeach
                        </ul>

                    </div>
                </div>
            </section>
            @if(auth()->user()->hasAnyRole('organization admin', 'organization staff'))

            <section aria-labelledby="section-1-title">

                <div class="rounded-lg bg-white overflow-hidden shadow">
                    <div class="p-6">
                        <!-- Your content -->
                        <h2>
                            Organization's Detail
                        </h2>
                        <ul role="list" class="divide-y divide-gray-200">
                            <li class="py-4 flex">

                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->organization->name }}</p>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->organization->email }}</p>
                                </div>
                            </li>

                            <li class="py-4 flex">

                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Phone: {{ auth()->user()->organization->phone }}</p>
                                </div>
                            </li>

                            <li class="py-4 flex">

                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Province: {{ auth()->user()->organization->province }}</p>
                                </div>
                            </li>
                            <li class="py-4 flex">
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->organization->address }}, {{ auth()->user()->organization->location }}</p>
                                    <p class="text-sm text-gray-500">{{ auth()->user()->organization->city }}, {{ auth()->user()->organization->postcode }}</p>
                                </div>
                            </li>
                            @if(auth()->user()->hasRole('organization admin'))
                            <li class="py-4 flex justify-end">

                                    <div class="ml-3">
                                        <a href="{{ route('organizations.show', auth()->user()->organization)  }}"
                                           class="inline-flex items-center px-4 py-2 border border-transparent
                                        shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">


                                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356
                                                 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Update
                                        </a>
                                    </div>

                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </section>
            @endif
        </div>

        <!-- Right column -->
        <div class="grid grid-cols-1 gap-4">
            <section aria-labelledby="section-2-title">

                <div class="rounded-lg bg-white overflow-hidden shadow">
                    <div class="p-6">
                        <!-- Your content -->
                        <h2>
                            Users's Detail
                        </h2>
                        <ul role="list" class="divide-y divide-gray-200">
                            <li class="py-4 flex">

                                <div class="ml-3 flex">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}

                                    </p>
                                    @if(auth()->user()->hasRole('organization admin'))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-5 w-5 -mt-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>
                                    @endif
                                    @if(auth()->user()->hasRole('emiweb admin'))
                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-5 w-5 -mt-2 text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                    @if(auth()->user()->hasRole('super admin'))
                                        <lord-icon
                                                src="https://cdn.lordicon.com/giaigwkd.json"
                                                trigger="loop"
                                                colors="primary:#c71f16"
                                                state="hover"
                                                style="width:20px;height:20px">
                                        </lord-icon>
                                    @endif

                                </div>
                            </li>

                            <li class="py-4 flex">

                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->email }}</p>
                                </div>
                            </li>

                            <li class="py-4 flex">

                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ auth()->user()->roles()->first()->name }}</p>

                                </div>
                            </li>
                            <li class="py-4 flex justify-end">

                                <div class="ml-3">

                                    <a href="{{ route('organizations.users.edit', [auth()->user()->organization,auth()->user()])  }}"
                                            type="button" class="inline-flex items-center px-4 py-2 border border-transparent
                                    shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">


                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356
                                             2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        Update
                                    </a>

                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </section>

            @if(auth()->user()->hasAnyRole('organization admin', 'organization staff'))
            <section aria-labelledby="section-2-title">

                <div class="rounded-lg bg-white overflow-hidden shadow">
                    <div class="p-6">
                        <h2>
                            Staff List
                        </h2>
                        <!-- Your content -->
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach(auth()->user()->organization->users as $staff)
                            <li class="py-4 flex justify-between">

                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 flex">{{ $staff->name }}
                                        @if($staff->hasRole('organization admin'))
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-5 w-5 -mt-2 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                            </svg>
                                        @endif

                                    </p>
                                    <p class="text-sm text-gray-500">{{ $staff->email }}</p>
                                </div>
                                @if(auth()->user()->hasRole('organization admin'))
                                    <div class="ml-3">
                                        <a href="{{ route('organizations.users.edit', [auth()->user()->organization,$staff])  }}" type="button" class="inline-flex items-center px-4 py-2 border border-transparent
                                        shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">


                                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356
                                                 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Update
                                        </a>
                                    </div>
                                @endif
                            </li>
                            @endforeach


                        </ul>
                    </div>
                </div>
            </section>
            @endif
        </div>
    </div>
</x-app-layout>
