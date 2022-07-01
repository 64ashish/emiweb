<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section aria-labelledby="section-1-title">

            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">
                    <div class="bg-white py-4 pl-4 pr-3 border-gray-300 shadow-sm">
                       <p class="text-left text-sm font-semibold text-gray-900 pb-4">
                           {{ __('Advanced search') }} : Den danska emigrantdatabasen
                       </p>
                        @if(isset($keywords))
                            {!! Form::model($keywords,['route' => 'danishemigration.search'])  !!}
                        @endif
                        @if(!isset($keywords))
                        {!! Form::open(['route' => 'danishemigration.search'])  !!}
                        @endif

                            <div class="grid grid-cols-2 gap-4">
                                <div class="sm:grid sm:grid-cols-3 sm:items-start">
                                    <label for="first_name"
                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ __('First name') }} </label>
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

                                <div class="sm:grid sm:grid-cols-3 sm:items-start">
                                    <label for="last_name"
                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ __('Last name') }} </label>
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

                                <div class="sm:grid sm:grid-cols-3 sm:items-start">
                                    <label for="profession"
                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ __('Profession') }} </label>
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

                                <div class="sm:grid sm:grid-cols-3 sm:items-start">
                                    <label for="birth_place"
                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ __('Birth place') }} </label>
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

                                <div class="sm:grid sm:grid-cols-3 sm:items-start">
                                    <label for="last_resident"
                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ __('Last resident') }} </label>
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

                                <div class="sm:grid sm:grid-cols-3 sm:items-start">
                                    <label for="destination_country"
                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ __('Destination country') }} </label>
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

                                <div class="sm:grid sm:grid-cols-3 sm:items-start">
                                    <label for="destination_city"
                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                        {{ __('Destination city') }} </label>
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

                                <div class="sm:grid sm:grid-cols-3 items-start justify-items-start">
                                    <span></span>
                                    <span></span>
                                    <button type="submit" class="inline-flex items-center px-8 py-2 border
                                    border-transparent text-base font-medium rounded-md shadow-sm text-white
                                    bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2
                                    focus:ring-offset-2 focus:ring-indigo-500">{{ __('Search') }}</button>

                                </div>

                            </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="inline-block min-w-full py-8 align-middle">

                        <div class="shadow-sm ring-1 ring-black ring-opacity-5">

                            <table class="min-w-full border-separate divide-gray-300" style="border-spacing: 0">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900
                                backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">{{ __('Full name') }}</th>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900
                                backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">{{ __('Profession') }}</th>
                                    <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter sm:table-cell">{{ __('Birth place') }}</th>
                                    <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter lg:table-cell">{{ __('Last resident') }}</th>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter">{{ __('Record date') }}</th>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter">
                                        {{ __('Destination location') }}</th>

                                    </th>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 text-right py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">

                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white">
                                @foreach($records as $record)
                                    <tr class="odd:bg-white even:bg-gray-100">
                                        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                    font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                            {{ $record->first_name }} {{ $record->last_name }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden sm:table-cell">{{ $record->profession}}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden sm:table-cell"> {{ $record->birth_place}}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden lg:table-cell">{{ $record->last_resident }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">{{ $record->traveled_on }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">
                                            {{  $record->destination_city }}, {{ $record->destination_country }}
                                        </td>
                                        <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                                                     text-sm text-right font-medium sm:pr-6 lg:pr-8">
                                            <a href="{{ route('records.show', ['arch'=> '1','id'=>$record->id]) }}" class="inline-flex text-indigo-700
                                           items-center px-3 py-1.5 text-indigo-700">View</a>
                                        </td>
                                    </tr>
                                @endforeach

                                <!-- More people... -->
                                </tbody>
                            </table>
                            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>



    </div>
</x-app-layout>
