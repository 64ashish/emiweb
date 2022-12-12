<x-admin-layout>


    {!! Form::model($archive,['route' => ['admin.archives.update', $archive], 'method' => 'put'],['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}

    <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5">
        <div>

            @csrf

            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    Name </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">

                    {!! Form::text('name', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'name']) !!}
                    @error('name')
                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                    </p>@enderror
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="place" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    Place </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">

                    {!! Form::text('place', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'place']) !!}
                    @error('place')
                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                    </p>@enderror
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="place" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    Total Records </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">

                    {!! Form::text('total_records', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'total_records']) !!}
                    @error('total_records')
                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                    </p>@enderror
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="detail" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    Details </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">

                    {!! Form::textarea('detail', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'detail']) !!}
                    @error('detail')
                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                    </p>@enderror
                </div>
            </div>

            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="detail" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                    Link </label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">

                    {!! Form::text('link', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'link']) !!}
                    @error('detail')
                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                    </p>@enderror
                </div>
            </div>


            <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                <label for="detail" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                     Owner's Detail</label>
                <div class="mt-1 sm:mt-0 sm:col-span-2">

                    {!! Form::textarea('owner_info', null,
                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                            'id' => 'detail']) !!}
                    @error('owner_info')
                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                    </p>@enderror
                </div>
            </div>


        </div>

        <div class="pt-5">
            <div class="flex justify-end">
                <button type="button" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</button>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Save</button>
            </div>
        </div>
    </div>
    </form>

</x-admin-layout>
