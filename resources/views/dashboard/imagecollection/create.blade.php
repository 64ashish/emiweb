<x-app-layout>
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            {!! Form::open(['route' => ['ImageCollections.store', request('archive') ]],['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}
            <dl class="sm:divide-y sm:divide-gray-200 grid grid-cols-1 pb-4">



                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5 py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <label  class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                           Name </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text("name", null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'name']) !!}

                            <p class="mt-2 text-sm text-red-600" id="email-error">
                            </p>
                        </div>
                    </div>

                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 py-4  sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <label for="details" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Details </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">

                        {!! Form::text('details', null,
                                ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                'id' => 'details']) !!}
                        @error('details')
                        <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                        </p>@enderror
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <label for="type" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                        Type </label>
                    <div class="mt-1 sm:mt-0 sm:col-span-2">

                        {!! Form::text('type', null,
                                ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                'id' => 'type']) !!}
                        @error('type')
                        <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                        </p>@enderror
                    </div>
                </div>


            </dl>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent
                             shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                             focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Create new record
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

</x-app-layout>
