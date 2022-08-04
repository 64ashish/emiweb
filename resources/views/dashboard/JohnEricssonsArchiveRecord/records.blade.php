<x-app-layout>
    <!-- Main 3 column grid -->
    @include('dashboard._breadcrumb')

    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section class="pt-6" aria-labelledby="section-1-title">

            <div class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <p class="text-left text-sm font-semibold text-gray-900 pb-4">
                    {{ __('Search in') }}  John Ericssons samling
                </p>

                @if(auth()->user()->hasRole('regular user|subscriber'))
                @if(isset($keywords))
                {!! Form::model($keywords,['route' => 'jear.search']) !!}
                @endif
                @if(!isset($keywords))
                {!! Form::open(['route' => 'jear.search']) !!}
                @endif

                    <div class="grid grid-cols-2 gap-4 pb-4">
                        <div class="sm:grid sm:grid-cols-3 sm:items-start">
                            <label for="first_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
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
                            <label for="last_name" class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
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
                    </div>

                    @include('dashboard._filtersattributes')


                {!! Form::close() !!}
                @endif

            </div>

            @if(isset($records))
                <div class="mt-8 flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">



                                <table class="min-w-full table-auto border-separate" style="border-spacing: 0">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900
                                backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">Full name</th>
                                        @foreach($defaultColumns as $column)
                                            <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter sm:table-cell">{{ __(ucfirst(str_replace('_', ' ', $column))) }} </th>
                                        @endforeach

                                        @foreach($populated_fields as $pop_fields)
                                            <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter sm:table-cell">{{ __(ucfirst(str_replace('_', ' ', $pop_fields))) }} </th>
                                        @endforeach

                                    </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                    @foreach($records as $record)

                                        <tr class="odd:bg-white even:bg-gray-100 hover:bg-indigo-700 text-gray-900 hover:text-white ">

                                            <td class="whitespace-nowrap border-b border-gray-200 py-2 pl-4 pr-3 text-sm
                                                                        font-medium  sm:pl-6 lg:pl-8">
                                                <a href="{{ route('records.show', ['arch'=> $record->archive->id,'id'=>$record->id]) }}" class="block">
                                                    {{ $record->first_name }} {{ $record->last_name }}
                                                </a>
                                            </td>
                                            @foreach($defaultColumns as $column)
                                                <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                         hidden sm:table-cell">
                                                    <a href="{{ route('records.show', ['arch'=> $record->archive->id,'id'=>$record->id]) }}" class="block">
                                                        {{ $record[$column]}}
                                                    </a>
                                                </td>
                                            @endforeach

                                            @foreach($populated_fields as $pop_fields)
                                                <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                        hidden sm:table-cell">
                                                    <a href="{{ route('records.show', ['arch'=> $record->archive->id,'id'=>$record->id]) }}" class="block">
                                                        {{ $record[$pop_fields]}}
                                                    </a>
                                                </td>
                                            @endforeach

                                        </tr>

                                    @endforeach

                                    <!-- More people... -->
                                    </tbody>
                                </table>
                                <div
                                        class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">

                                </div>
                            </div>
                            {{ $records->appends(array('action' => $keywords['action']))->links() }}

                        </div>
                    </div>
                </div>
            @endif
        </section>

    </div>
</x-app-layout>
