<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section aria-labelledby="section-1-title">

            <div class="bg-white py-4 pl-4 pr-3 border-gray-300 shadow-sm">
                <p class="text-left text-sm font-semibold text-gray-900 pb-4">
                    {{ __('Advanced search') }} : SCB Immigranter
                </p>
                @if(isset($keywords))
                    {!! Form::model($keywords,['route' => 'sevkrc.search'])  !!}
                @endif
                @if(!isset($keywords))
                    {!! Form::open(['route' => 'sevkrc.search'])  !!}
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

                    @include('dashboard._filtersattributes')

                    <div class="sm:flex justify-around">
                        <span></span>
                        <button type="submit" name="action" value="search" class="inline-flex items-center px-8 py-2 border
                                    border-transparent text-base font-medium rounded-md shadow-sm text-white
                                    bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2
                                    focus:ring-offset-2 focus:ring-indigo-500">{{ __('Search') }}</button>
                        <button type="submit" name="action" value="filter" class="inline-flex items-center px-8 py-2 border
                                    border-transparent text-base font-medium rounded-md shadow-sm text-white
                                    bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2
                                    focus:ring-offset-2 focus:ring-indigo-500">{{ __('Filter') }}</button>

                    </div>

                </div>
                {!! Form::close() !!}
            </div>

            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 sm:-mx-6 lg:-mx-8">

                    <div class="inline-block min-w-full py-2 align-middle">
                        <div class="shadow-sm ring-1 ring-black ring-opacity-5">
                            <table class="min-w-full border-separate" style="border-spacing: 0">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900
                                backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">{{ __('Full name') }}</th>
                                    <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter sm:table-cell"> {{ __('Gender') }}</th>
                                    <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter lg:table-cell"> {{ __('Profession') }}</th>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter"> {{ __('Birth year') }}</th>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter">
                                        {{ __('From Country') }}
                                    </th>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter">
                                        {{ __('Nationality') }}
                                    </th>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 text-right py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">

                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white">
                                @foreach($records as $record)
                                    <tr>
                                        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                        font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                            {{ $record->first_name }} {{ $record->last_name }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                        text-gray-500 hidden sm:table-cell">{{ $record->sex}}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                        text-gray-500 hidden lg:table-cell">{{ $record->profession }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                        text-gray-500">{{ $record->birth_year }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                        text-gray-500">{{ $record->from_country }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                        text-gray-500">
                                            {{  $record->nationality }}
                                        </td>
                                        <td class="relative whitespace-nowrap border-b border-gray-200 py-4 pr-4 pl-3
                                                                         text-sm text-right font-medium sm:pr-6 lg:pr-8">
                                            @if(auth()->user()->hasRole(['regular user', 'subscriber']))
                                                <a href="{{ route('records.show', ['arch'=> $record->archive->id,'id'=>$record->id]) }}" class="inline-flex text-indigo-700
                                               items-center px-3 py-1.5 text-indigo-700">{{ __('Read more') }}</a>
                                            @else
                                                <a href="{{ route('organizations.archives.show', [$organization, $record->archive,$record]) }}" class="inline-flex text-indigo-700
                                               items-center px-3 py-1.5 text-indigo-700">{{ __('Read more') }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                                {{ $records->links() }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </div>
</x-app-layout>
