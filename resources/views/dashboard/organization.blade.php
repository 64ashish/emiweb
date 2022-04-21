<x-app-layout>
    @role('organization admin')
    <div class="lg:grid lg:gap-x-5">


        <div class="space-y-6 sm:px-6 lg:px-0" id="organization_detail">

            {!! Form::model($TheOrganization,['route' => ['organizations.update', $TheOrganization], 'method' => 'put'],
                    ['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}
{{--            {!! Form::open(['route' =>['organizations.update',$TheOrganization], 'method' => 'put']) !!}--}}


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




            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div class="md:grid md:grid-cols-3 md:gap-6">
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Archive Access</h3>
                            <p class="mt-1 text-sm text-gray-500">Archives Associated with this organization</p>
                        </div>
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <fieldset>
                                @foreach($TheOrganization->archives as $archive)

                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-start">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">{{ $archive->name }}</p>
                                                <p class="text-sm text-gray-500 truncate">Total records: xyz</p>
                                            </div>
                                            <div>
                                                <a href="#" class="inline-flex items-center shadow-sm px-2.5 py-0.5 border border-gray-300 text-sm leading-5 font-medium rounded-full text-gray-700 bg-white hover:bg-gray-50"> View </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </fieldset>
                        </div>
                    </div>
                </div>

            </div>



            <div class="shadow sm:rounded-md sm:overflow-hidden">
                <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Users</h3>
                        <p class="mt-1 text-sm text-gray-500">Users associated with this organization.</p>
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

                                        {!! Form::model($user->roles,['route' => ['users.sync-role',$user]],
                                                ['class' => 'inline-flex'])  !!}

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


                                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-6 w-6"
                                                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955
                                                              0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9
                                                              11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12
                                                              9v2m0 4h.01" />
                                                </svg>
                                                Assign
                                            </button>
                                        </div>


                                        {!! Form::close() !!}

                                        @can('syncWithOrganization',$user)
                                        {!! Form::open(['route' => ['organizations.users.sync', $TheOrganization, $user]], ['class' => 'inline-flex'])  !!}

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
                                        @endcan



                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                </div>

            </div>
        </div>
    </div>
    @endrole

</x-app-layout>
