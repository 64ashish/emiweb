<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:grid-cols-3 lg:gap-8">
        <!-- Left column -->
        <div class="grid grid-cols-1 gap-4 lg:col-span-2">
            <section aria-labelledby="section-1-title">

                <div class="rounded-lg bg-white overflow-hidden shadow">
                    <div class="pb-6">
                        <ul role="list">
                            @foreach($catArchives as $category => $archives)
                                <li>
                                    <p class="text-sm font-medium text-black-900 px-6 pt-4">{{ $category }}</p>
                                    <ul class="">
{{--                                        @dd($archive)--}}
                                        @foreach($archives as $archive)

                                        <li class="odd:bg-white even:bg-gray-100 px-6 py-4">
                                                <div class="flex justify-between">
                                                    <div>{{ __($archive->name) }}</div>
                                                    <a href="{{ route('organizations.archives.records', ['organization'=> auth()->user()->organization,'archive'=>$archive->id]) }}">
                                                        {{ __('View archive') }} </a>
                                                </div>
                                                <span class=" text-sm text-gray-500 ">
                                                    {{ $archive->total_records}} Records
                                                </span>
                                        </li>
                                        @endforeach
                                    </ul>
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
                                        shadow-sm text-sm font-medium rounded-md text-white {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }} hover:bg-indigo-700
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">



                                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
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

                                <div class="ml-3 flex flex-col">
                                    <p class="text-sm font-medium text-gray-900 flex">{{ auth()->user()->name }}
                                        @if(auth()->user()->hasRole('organization admin'))
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 ml-2 h-5 w-5  text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                            </svg>
                                        @endif
                                        @if(auth()->user()->hasRole('emiweb admin'))
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 ml-2 h-5 w-5  text-emerald-600" viewBox="0 0 20 20" fill="currentColor">
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

                                    </p>


                                    <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>

                                    <p class="text-sm text-gray-500">{{ auth()->user()->roles()->first()->name }}</p>

                                </div>
                            </li>


                            <li class="py-4 flex justify-end">

                                <div class="ml-3">

                                    <a href="{{ route('organizations.users.edit', [auth()->user()->organization,auth()->user()])  }}"
                                            type="button" class="inline-flex items-center px-4 py-2 border border-transparent
                                    shadow-sm text-sm font-medium rounded-md text-white {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }} hover:bg-indigo-700
                                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        Edit
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
                                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-5 w-5 ml-2 h-5 w-5  text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                            </svg>
                                        @endif

                                    </p>
                                    <p class="text-sm text-gray-500">{{ $staff->email }}</p>
                                </div>
                                @if(auth()->user()->hasRole('organization admin'))
                                    <div class="ml-3">
                                        <a href="{{ route('organizations.users.edit', [auth()->user()->organization,$staff])  }}" type="button" class="inline-flex items-center px-4 py-2 border border-transparent
                                        shadow-sm text-sm font-medium rounded-md text-white {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }} hover:bg-indigo-700
                                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">



                                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                            Edit
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
