<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Archive Name</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Den danska emigrantdatabasen</p>
            </div>
            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">

                {!! Form::open(['route' => ['organizations.archives.records.store',$organization, $archive]],['class' => 'space-y-8 a divide-y divide-gray-200'])  !!}
                <dl class="sm:divide-y sm:divide-gray-200 grid grid-cols-1 sm:grid-cols-2">
                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5 py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <label for="first_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            First name </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('first_name', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'first_name']) !!}
                            @error('first_name')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Last Name </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('last_name', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'last_name']) !!}
                            @error('last_name')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="sex" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Gender
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('sex', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'sex']) !!}
                            @error('sex')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="age" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            age </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('age', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'age']) !!}
                            @error('age')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="birth_place" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Birth place
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('birth_place', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'birth_place']) !!}
                            @error('birth_place')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="last_resident" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Last resident </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('last_resident', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'last_resident']) !!}
                            @error('last_resident')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="profession" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Profession </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('profession', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'profession']) !!}
                            @error('profession')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="destination_city" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Destination city </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('destination_city', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'destination_city']) !!}
                            @error('destination_city')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="destination_country"
                               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Destination_country </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('destination_country', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'destination_country']) !!}
                            @error('destination_country')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="ship_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Ship Name
                        </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('ship_name', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'ship_name']) !!}
                            @error('ship_name')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="traveled_on" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Travel Date </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('traveled_on', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'traveled_on']) !!}
                            @error('traveled_on')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="contract_number" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Contract number </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('contract_number', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'contract_number']) !!}
                            @error('contract_number')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="comment" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Comment </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('comment', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'comment']) !!}
                            @error('comment')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="secrecy" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Secrecy </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('secrecy', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'secrecy']) !!}
                            @error('secrecy')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="travel_type" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Travel type </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('travel_type', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'travel_type']) !!}
                            @error('travel_type')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="source" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            Source </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('source', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'source']) !!}
                            @error('source')
                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                            </p>@enderror
                        </div>
                    </div>

                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:pt-5">
                        <label for="dduid" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                            DDUID </label>
                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                            {!! Form::text('dduid', null,
                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                    'id' => 'dduid']) !!}
                            @error('dduid')
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

    </div>
</x-app-layout>
