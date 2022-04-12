<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Organization: {{ $TheOrganization->name }}</h1>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                @role('super admin')
                <a href="{{ route('admin.organizations.edit', $TheOrganization) }}" class="inline-flex items-center justify-center rounded-md border
                border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700
                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Edit Organization</a>
                @endrole

                @hasanyrole('emiweb admin|emiweb staff')
                <a href="{{ route('emiweb.organizations.edit', $TheOrganization) }}" class="inline-flex items-center justify-center rounded-md border
                border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700
                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Edit Organization</a>
                @endhasanyrole

            </div>
        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-5">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Phone</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $TheOrganization->phone }}</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Email address</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $TheOrganization->email }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Location</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $TheOrganization->location }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Address</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $TheOrganization->address }}, {{ $TheOrganization->postcode }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">City</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $TheOrganization->city }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Province</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $TheOrganization->province }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Archive Access
                        <p>{{ $TheOrganization->name }} has access to these archives.</p>
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                @foreach($TheOrganization->archives as $archive)
                                <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                    <div class="w-0 flex-1 flex items-center">
                                        <!-- Heroicon name: solid/paper-clip -->

                                        <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                        <span class="ml-2 flex-1 w-0 truncate"> {{ $archive->name }} </span>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        @role('super admin')
                                        <a href="{{ route('admin.archives.show', $archive) }}" class="inline-flex items-center justify-center rounded-md border
                                            border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700
                                            focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">View</a>
                                        @endrole

                                        @hasanyrole('emiweb admin|emiweb staff')
                                        <a href="{{ route('emiweb.archives.show', $archive) }}" class="inline-flex items-center justify-center rounded-md border
                                            border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700
                                            focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">View</a>
                                        @endhasanyrole
                                    </div>
                                </li>
                                @endforeach

                            </ul>
                        </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Users

                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div>
                                @role('super admin')
                                    {!! Form::open(['route' => ['admin.organizations.users.search', $TheOrganization]],
                                            ['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}
                                @endrole
                                @hasanyrole('emiweb admin|emiweb staff')
                                {!! Form::open(['route' => ['emiweb.organizations.users.search', $TheOrganization]],
                                            ['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}
                                @endhasanyrole
                                    <label for="email" class="block text-sm font-medium text-gray-700">
                                        Search user to add with their email
                                    </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <div class="relative flex items-stretch flex-grow focus-within:z-10">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <!-- Heroicon name: solid/users -->
                                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016
                                                    0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119
                                                    16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                                </svg>
                                            </div>
                                            <input type="email" name="email" id="email" class="focus:ring-indigo-500
                                            focus:border-indigo-500 block w-full rounded-none rounded-l-md pl-10
                                            sm:text-sm border-gray-300" placeholder="example@example.com">
                                        </div>
                                        <button type="submit" class="-ml-px relative inline-flex items-center space-x-2
                                        px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-gray-700
                                        bg-gray-50 hover:bg-gray-100 focus:outline-none focus:ring-1
                                        focus:ring-indigo-500 focus:border-indigo-500">
                                            <!-- Heroicon name: solid/sort-ascending -->

                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M8 16l2.879-2.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243
                                                      4.242zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span>Search</span>
                                        </button>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                            @if($TheOrganization->users->count() > 0)
                                <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200 mt-5">
                                @foreach($TheOrganization->users as $user)
{{--                                    <li>{!! $user->roles->pluck('name') !!}</li>--}}
                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                        <div class="flex-1 flex items-center">
                                            <!-- Heroicon name: solid/paper-clip -->

                                            <span class="ml-2  truncate"> {{ $user->name }} </span>
                                            @if($user->roles->pluck('name')->contains('organization admin'))
                                                <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 h-5 w-5 -mt-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                                </svg>
                                            @endif
                                        </div>
                                        <div class="ml-4 flex gap-4 ">
                                            @role('super admin')
                                            {!! Form::model($user->roles,['route' => ['admin.users.sync-role',$user]],
                                                    ['class' => 'inline-flex'])  !!}
                                            @endrole
                                            @hasanyrole('emiweb admin|emiweb staff')
                                            {!! Form::model($user->roles,['route' => ['emiweb.users.sync-role',$user]],
                                                    ['class' => 'inline-flex'])  !!}
                                            @endhasanyrole

                                            <div class="flex gap-4">
                                                {!! Form::select('name',$roles ,$user->roles->implode('name', ', '),
                                                    ['class' => 'block w-full pl-3
                                                    pr-10 py-2 text-base border-gray-300 focus:outline-none
                                                    focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md']);
                                                !!}

                                                <button type="submit" class="inline-flex items-center px-3 py-2 border
                                                    border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white
                                                     bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2
                                                     focus:ring-offset-2 focus:ring-emerald-500">


                                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                                                    </svg>
                                                    Assign
                                                </button>
                                            </div>


                                            {!! Form::close() !!}

                                            @role('super admin')
                                            {!! Form::open(['route' => ['admin.organizations.users.sync', $TheOrganization, $user]], ['class' => 'inline-flex'])  !!}
                                            @endrole
                                            @hasanyrole('emiweb admin|emiweb staff')
                                            {!! Form::open(['route' => ['emiweb.organizations.users.sync', $TheOrganization, $user]], ['class' => 'inline-flex'])  !!}
                                            @endhasanyrole
                                                {!! Form::hidden('disconnect', true) !!}
                                                <button type="submit" class="inline-flex items-center px-3 py-2 border
                                                    border-transparent shadow-sm text-sm leading-4 font-medium rounded-md text-white
                                                     bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2
                                                     focus:ring-offset-2 focus:ring-red-500">

                                                    <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 7a4 4 0 11-8 0 4 4 0 018 0zM9 14a6 6 0 00-6 6v1h12v-1a6 6 0 00-6-6zM21 12h-6" />
                                                    </svg>
                                                    Unlink User
                                                </button>
                                            {!! Form::close() !!}


                                        </div>
                                    </li>
                                @endforeach
                                </ul>
                            @endif



                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-admin-layout>
