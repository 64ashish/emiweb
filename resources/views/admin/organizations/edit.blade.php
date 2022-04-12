<x-admin-layout>
    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
            <nav class="space-y-1 lg:fixed">
                <!-- Current: "bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white", Default: "text-gray-900 hover:text-gray-900 hover:bg-gray-50" -->
                <a href="#" class="bg-gray-50 text-indigo-700 hover:text-indigo-700 hover:bg-white group rounded-md px-3 py-2 flex items-center text-sm font-medium" aria-current="page">
                    <!--
                      Heroicon name: outline/user-circle

                      Current: "text-indigo-500 group-hover:text-indigo-500", Default: "text-gray-400 group-hover:text-gray-500"
                    -->
                    <svg class="text-indigo-500 group-hover:text-indigo-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="truncate"> Organization Details </span>
                </a>

                <a href="#" class="text-gray-900 hover:text-gray-900 hover:bg-gray-50 group rounded-md px-3 py-2 flex items-center text-sm font-medium">
                    <!-- Heroicon name: outline/key -->
                    <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                    </svg>
                    <span class="truncate"> Archives </span>
                </a>

                <a href="#" class="text-gray-900 hover:text-gray-900 hover:bg-gray-50 group rounded-md px-3 py-2 flex items-center text-sm font-medium">
                    <!-- Heroicon name: outline/credit-card -->
                    <svg class="text-gray-400 group-hover:text-gray-500 flex-shrink-0 -ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span class="truncate"> Users </span>
                </a>


            </nav>
        </aside>

        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9" id="organization_detail">
            @role('super admin')
            {!! Form::model($TheOrganization,['route' => ['admin.organizations.update', $TheOrganization], 'method' => 'put'],
                    ['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}
            @endrole
            @hasanyrole('emiweb admin|emiweb staff')
            {!! Form::model($TheOrganization,['route' => ['emiweb.organizations.update', $TheOrganization], 'method' => 'put'],
                    ['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}
            @endhasanyrole

                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Organization Details</h3>
                            <p class="mt-1 text-sm text-gray-500">These are basic details of your organization.</p>
                        </div>

                        <div class="flex flex-col gap-6">
                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Organization name
                                </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">

                                    {!! Form::text('name', null,
                                            ['id' => 'name',
                                                'class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500
                                            focus:border-indigo-500 sm:max-w-xs sm:text-sm border-gray-300 rounded-md']) !!}
                                    @error('name')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                    </p>@enderror

                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="phone" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Phone </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">

                                    {!! Form::text('phone', null,
                                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                            'id' => 'phone']) !!}
                                    @error('phone')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                    </p>@enderror
                                </div>
                            </div>



                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="fax" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Fax </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    {!! Form::text('fax', null,
                                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                            'id' => 'fax']) !!}
                                    @error('fax')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                    </p>@enderror
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="email" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Email Address </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    {!! Form::text('email', null,
                                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                            'id' => 'email']) !!}
                                    @error('email')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                    </p>@enderror
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="location" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Location </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    {!! Form::text('location', null,
                                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                            'id' => 'location']) !!}
                                    @error('location')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                    </p>@enderror
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="address" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Address </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    {!! Form::text('address', null,
                                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                            'id' => 'address']) !!}
                                    @error('address')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                    </p>@enderror
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="city" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    City </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    {!! Form::text('city', null,
                                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                            'id' => 'city']) !!}
                                    @error('city')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                    </p>@enderror
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="province" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Province </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">
                                    {!! Form::text('province', null,
                                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                            'id' => 'city']) !!}
                                    @error('province')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                    </p>@enderror
                                </div>
                            </div>

                            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                <label for="postcode" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                    Post Code </label>
                                <div class="mt-1 sm:mt-0 sm:col-span-2">

                                    {!! Form::text('postcode', null,
                                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                            'id' => 'postcode']) !!}
                                    @error('postcode')
                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                    </p>@enderror
                                </div>
                            </div>
                    </div>

                </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit" class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                    </div>
                </div>
            {!! Form::close() !!}

            @role('super admin')
            {!! Form::model($TheOrganization->archives,['route' => ['admin.organizations.archive.sync', $TheOrganization], 'method' => 'post'],
                    ['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}
            @endrole
            @hasanyrole('emiweb admin|emiweb staff')
            {!! Form::model($TheOrganization->archives,['route' => ['emiweb.organizations.archive.sync', $TheOrganization], 'method' => 'post'],
                    ['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}
            @endhasanyrole

{{--            {!! Form::model($TheOrganization->archives,['route' => ['admin.organizations.archive.sync', $TheOrganization], 'method' => 'post'],--}}
{{--['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}--}}
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                        <div class="md:grid md:grid-cols-3 md:gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-lg font-medium leading-6 text-gray-900">Archive Access</h3>
                                <p class="mt-1 text-sm text-gray-500">Select which archive this organization should have.</p>
                            </div>
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <fieldset>
                                    @foreach($archives as $archive)
                                        <div class="mt-4 space-y-4">
                                            <div class="flex items-start">
                                                <div class="h-5 flex items-center">
                                                    {!! Form::checkbox('archive_id[]',$archive->id,
                                                            in_array($archive->id, $TheOrganization->archives->pluck('id')->toArray())? 'checked' : '' ,
                                                            ['class' => 'focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded', 'id' => 'archive-id-'.$archive->id]) !!}
                                                </div>
                                                <div class="ml-3 text-sm">
                                                    <label for="archive-id-{{$archive->id}}" class="font-medium text-gray-700">{{ $archive->name }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </fieldset>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm
                        text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                        <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent
                         shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                         focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
                    </div>
                </div>
            {!! Form::close() !!}


                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Users</h3>
                            <p class="mt-1 text-sm text-gray-500">Users associated with this organization.</p>
                        </div>
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
                                            @endhasanyrole                                            {!! Form::hidden('disconnect', true) !!}
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

                </div>

        </div>
    </div>

</x-admin-layout>
