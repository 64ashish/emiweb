
<div class="mt-8 flex flex-col" x-init="document.getElementById('results').scrollIntoView()">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8" id="results">
        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">



                <table class="min-w-full table-auto border-separate" style="border-spacing: 0">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class=" border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900  sm:table-cell">Full name</th>
                        @foreach($defaultColumns as $column)
                            <th scope="col" class=" border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900  sm:table-cell">{{ __(ucfirst(str_replace('_', ' ', $column))) }} </th>
                        @endforeach

                        @foreach($populated_fields as $pop_fields)
                            <th scope="col" class=" border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900  sm:table-cell">{{ __(ucfirst(str_replace('_', ' ', $pop_fields))) }} </th>
                        @endforeach

                    </tr>
                    </thead>
                    <tbody class="bg-white">
                    @if(auth()->user()->hasRole('organization admin|organization staff') )
                        @foreach($records as $record)
                            <tr class="odd:bg-white even:bg-gray-100 hover:bg-indigo-700 text-gray-900 hover:text-white ">
                                <td class="whitespace-nowrap border-b border-gray-200 py-2 pl-4 pr-3 text-sm
                                                                        font-medium  sm:pl-6 lg:pl-8">

                                    <a href="{{ route('organizations.archives.show', ['organization'=> auth()->user()->organization,'archive'=>$record->archive->id, 'id'=>$record->id]) }}" class="block">
                                        {{ $record->first_name }} {{ $record->last_name }}
                                    </a>
                                </td>
                                @foreach($defaultColumns as $column)
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                         hidden sm:table-cell">
                                        <a href="{{ route('organizations.archives.show', ['organization'=> auth()->user()->organization,'archive'=>$record->archive->id, 'id'=>$record->id]) }}" class="block">
                                            {{ $record[$column]}}
                                        </a>
                                    </td>
                                @endforeach

                                @foreach($populated_fields as $pop_fields)
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                        hidden sm:table-cell">
                                        <a href="{{ route('organizations.archives.show', ['organization'=> auth()->user()->organization,'archive'=>$record->archive->id, 'id'=>$record->id]) }}" class="block">
                                            {{ $record[$pop_fields]}}
                                        </a>
                                    </td>
                                @endforeach

                            </tr>

                        @endforeach
                    @endif

                    @if(auth()->user()->hasRole('regular user|subscriber') )
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
                    @endif


                    <!-- More people... -->
                    </tbody>
                </table>
                <div
                        class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">

                </div>
            </div>
            {{ $records->appends(request()->except(['_token']))->links() }}

        </div>
    </div>
</div>
