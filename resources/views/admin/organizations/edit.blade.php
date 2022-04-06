<x-admin-layout>
    {!! Form::model($organization,['route' => ['admin.organizations.update', $organization], 'method' => 'put'],
    ['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}
    {{--    <form class="space-y-8 divide-y divide-gray-200" method="POST"--}}
    {{--          action="{{ route('organizations.store') }}">--}}
    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5 bg-white shadow overflow-hidden sm:rounded-lg px-4 py-5 ">


        <div class="pt-8 space-y-6 sm:pt-10 sm:space-y-5">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Basic Information</h3>
                {{--                    @csrf--}}
            </div>
            <div class="space-y-6 sm:space-y-5">
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


        <div class="pt-5">
            <div class="flex justify-end">
                <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm
                font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2
                focus:ring-indigo-500">Cancel</button>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent
                shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
            </div>
        </div>
    </div>
    </form>


    {!! Form::model($organization->archives,['route' => ['admin.organization.archive.sync', $organization], 'method' => 'post'],
    ['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}
    <div class="space-y-6 mt-8">
        <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
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
                                                in_array($archive->id, $organization->archives->pluck('id')->toArray())? 'checked' : '' ,
                                                ['class' => 'focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded', 'id' => 'archive-id-'.$archive->id]) !!}
{{--                                        <input id="comments" name="comments" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">--}}
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
            <div class="flex justify-end">
                <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</x-admin-layout>
