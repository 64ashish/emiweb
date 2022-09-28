<div class="mt-8 flex flex-col" x-init="document.getElementById('results').scrollIntoView()">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8" id="results">

        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <h4 class="pb-6" x-show="!openDetails"> {{ __("Your search returned") ." ". $records->total()." ". __("results") }}
            </h4>
            <div
                 class="overflow-hidden shadow ring-1 mb-4 ring-black ring-opacity-5 md:rounded-lg">

                <table x-show="!openDetails"
                       class="min-w-full table-auto border-separate" style="border-spacing: 0" >
                    <thead class="bg-gray-50">
                    <tr>

                        @if($records->first()->first_name != null or $records->first()->last_name != null)
                            <th x-on:click="sortByColumn" scope="col" class=" border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900  sm:table-cell">{{ __("Full name") }}

                            </th>
                        @endif
                        @foreach($defaultColumns as $column)
                            <th  x-on:click="sortByColumn" scope="col" class=" border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900  sm:table-cell">{{ __(ucfirst(str_replace('_', ' ', $column))) }} </th>
                        @endforeach

                        @foreach($populated_fields as $pop_fields)
                            <th x-on:click="sortByColumn"  scope="col" class=" border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900  sm:table-cell">{{ __(ucfirst(str_replace('_', ' ', $pop_fields))) }} </th>
                        @endforeach

                    </tr>
                    </thead>

                    <tbody  x-ref="tbody"  class="bg-white">
                    @if(auth()->user()->hasRole('organization admin|organization staff') )
                        @foreach($records as $record)
                            <tr class="odd:bg-white even:bg-gray-100 hover:bg-indigo-700 text-gray-900 hover:text-white ">
                                @if(!empty($record->first_name) or !empty($record->last_name))
                                    <td class="whitespace-nowrap border-b border-gray-200 py-2 pl-4 pr-3 text-sm
                                                                        font-medium  sm:pl-6 lg:pl-8">
                                        <a href="{{ route('organizations.archives.show', ['organization'=> auth()->user()->organization,'archive'=>$record['archive_id'], 'id'=>$record->id]) }}" class="block">
                                            {{ $record->first_name }} {{ $record->last_name }}
                                        </a>
                                    </td>
                                @endif
                                @foreach($defaultColumns as $column)
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                         hidden sm:table-cell">
                                        <a href="{{ route('organizations.archives.show', ['organization'=> auth()->user()->organization,'archive'=>$record->archive_id, 'id'=>$record->id]) }}" class="block">
                                            {{ $record[$column]}}
                                        </a>
                                    </td>
                                @endforeach

                                @foreach($populated_fields as $pop_fields)
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                        hidden sm:table-cell">
                                        <a href="{{ route('organizations.archives.show', ['organization'=> auth()->user()->organization,'archive'=>$record->archive_id, 'id'=>$record->id]) }}" class="block">
                                            {{ $record[$pop_fields]}}
                                        </a>
                                    </td>
                                @endforeach

                            </tr>

                        @endforeach
                    @endif

                    @if(auth()->user()->hasRole('regular user|subscriber') )
                        @foreach($records as $record)

                            <tr  @click="openDetails = ! openDetails, selectedRecord({{ $record->id }})"
                                 class="odd:bg-white even:bg-gray-100 hover:bg-indigo-700 text-gray-900 hover:text-white cursor-pointer">
                                @if(!empty($record->first_name) or !empty($record->last_name))
                                    <td  class="whitespace-nowrap border-b border-gray-200 py-2 pl-4 pr-3 text-sm
                                                                        font-medium  sm:pl-6 lg:pl-8">

                                        {{--                                        <a href="{{ route('records.show', ['arch'=> $record->archive_id,'id'=>$record->id]) }}" class="block">--}}
                                        <div> {{ $record->first_name }} {{ $record->last_name }}</div>
                                        {{--                                        </a>--}}
                                    </td>
                                @endif
                                @foreach($defaultColumns as $column)
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                         hidden sm:table-cell">

                                        {{ $record[$column]}}

                                    </td>
                                @endforeach

                                @foreach($populated_fields as $pop_fields)
                                    <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm
                                                                        hidden sm:table-cell">

                                        {{ $record[$pop_fields]}}

                                    </td>
                                @endforeach

                            </tr>

                        @endforeach

                        {{--                        {{ print_r($records) }}--}}
                    @endif


                    <!-- More people... -->
                    </tbody>
                </table>
                {{--                {{ dd($recordDetails) }}--}}

                {{--                {{ dump(json_encode($recordDetails)) }}--}}

                <div x-show="openDetails"  class="flex flex-col">
                    <div class="flex">
                        <span class="isolate inline-flex rounded-md  p-4">
                        <button type="button" class="relative inline-flex items-center rounded-l-md border border-gray-300
                       bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500
                        focus:outline-none focus:ring-1 focus:ring-indigo-500" @click="openDetails = ! openDetails, detail=''">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>

                            Back to results</button>
                      <button type="button" class="relative -ml-px inline-flex items-center border border-gray-300
                       bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500
                        focus:outline-none focus:ring-1 focus:ring-indigo-500" @click="selectedRecord(previous)" x-show="previous">

                          <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                              <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                            </svg>
                          Previous record</button>
                      <a x-bind:href="recordURL" type="button" class="relative -ml-px inline-flex items-center border border-gray-300
                       bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-gray-50 hover:text-indigo-600 focus:z-10 focus:border-indigo-500
                        focus:outline-none focus:ring-1 focus:ring-indigo-500" >

                          Record detailed page

                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="ml-2  w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.042 21.672L13.684 16.6m0 0l-2.51 2.225.569-9.47 5.227 7.917-3.286-.672zM12 2.25V4.5m5.834.166l-1.591 1.591M20.25 10.5H18M7.757 14.743l-1.59 1.59M6 10.5H3.75m4.007-4.243l-1.59-1.59" />
                            </svg>



                        </a>
                      <button type="button" class="relative -ml-px inline-flex items-center rounded-r-md border border-gray-300
                       bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500
                        focus:outline-none focus:ring-1 focus:ring-indigo-500" @click="selectedRecord(next)" x-show="next">Next record
                      <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                          <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                      </button>
                    </span>
                    </div>
                    <div class="border-t border-gray-200 px-4 py-5 sm:p-0 bg-white" >
                        <dl class="sm:divide-y sm:divide-gray-200 grid grid-cols-1 sm:grid-cols-2 quickwrapper">

                            <template x-for="(value, field) in detail" :key="field">

                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 ">
                                    <dt class="text-sm font-medium text-gray-500 capitalize" x-text="prepareField(field)">

                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" x-text="value">

                                    </dd>

                                </div>

                            </template>


                        </dl>


                    </div>
                </div>
            </div>
            <span x-show="!openDetails">
                {{ $records->appends(request()->except(['_token']))->links() }}
            </span>

        </div>
    </div>
</div>





