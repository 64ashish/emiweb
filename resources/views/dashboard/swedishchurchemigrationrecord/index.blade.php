<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section aria-labelledby="section-1-title">

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
                                    <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter sm:table-cell">Place of birth</th>
                                    <th scope="col" class="sticky top-0 z-10 hidden border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter lg:table-cell">Last place of resident</th>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur
                                backdrop-filter">From Parish</th>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 py-3.5 pr-4 pl-3 text-left backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">
                                        Destination
                                    </th>
                                    <th scope="col" class="sticky top-0 z-10 border-b border-gray-300 bg-gray-50
                                bg-opacity-75 text-right py-3.5 pr-4 pl-3 backdrop-blur backdrop-filter sm:pr-6 lg:pr-8">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white">
                                @foreach($records as $record)
                                    <tr>
                                        <td class="whitespace-nowrap border-b border-gray-200 py-4 pl-4 pr-3 text-sm
                                                                    font-medium text-gray-900 sm:pl-6 lg:pl-8">
                                            {{ $record->first_name }} {{ $record->last_name }}  </td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden sm:table-cell">{{ $record->birth_place}}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500 hidden lg:table-cell">{{ $record->last_resident }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">{{ $record->from_parish }}</td>
                                        <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                    text-gray-500">
                                            {{ $record->destination_country }}
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

                                <!-- More people... -->
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
