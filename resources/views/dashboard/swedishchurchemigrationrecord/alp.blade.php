<div class="mt-8 flex flex-col" x-init="document.getElementById('results').scrollIntoView()">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8" id="results">

        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
            <h4 class="pb-6"> {{ __("Your search returned") ." ". $records->total()." ". __("results") }}
            </h4>
            <div x-data="data()"
                    class="overflow-hidden shadow ring-1 mb-4 ring-black ring-opacity-5 md:rounded-lg">
                <table x-show="!openDetails"
                       class="min-w-full table-auto border-separate" style="border-spacing: 0" >
                    <thead class="bg-gray-50">
                    <tr>
                        {{--                        {{ dump($records->first()->ashish_name) }}--}}
                        {{--                        {{ dump($record->first_name) }}--}}
                        @if($records->first()->first_name != null or $records->first()->last_name != null)
                            {{--                            {{ dump($record->first_name) }}--}}
                            <th  scope="col" class=" border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900  sm:table-cell">{{ __("Full name") }}

                            </th>
                        @endif
                        @foreach($defaultColumns as $column)
                            <th   scope="col" class=" border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900  sm:table-cell">{{ __(ucfirst(str_replace('_', ' ', $column))) }} </th>
                        @endforeach

                        @foreach($populated_fields as $pop_fields)
                            <th   scope="col" class=" border-b border-gray-300 bg-gray-50
                                bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900  sm:table-cell">{{ __(ucfirst(str_replace('_', ' ', $pop_fields))) }} </th>
                        @endforeach

                    </tr>
                    </thead>

                    <tbody  class="bg-white">
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
                    @php ($recordDetails[] = '')
                    @if(auth()->user()->hasRole('regular user|subscriber') )
                        @foreach($records as $record)


                            @foreach ($fieldsToDisply as $field=>$value)
                                @php ($recordDetails[$value] = $record[$field] )
{{--                                {{ $value }}--}}
                            @endforeach
{{--                            {{ dd($recordDetails) }}--}}

                            <tr  @click="openDetails = ! openDetails, detail= {{ json_encode($recordDetails) }}"
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
                    @endif


                    <!-- More people... -->
                    </tbody>
                </table>

{{--                {{ dump(json_encode($recordDetails)) }}--}}

                <div x-show="openDetails" >
                    <div class="p-4">
                        <span class="mr-2 ">Next</span>
                        <span class="mr-2 ">Previous</span>
                        <span class="mr-2 " @click="openDetails = ! openDetails, detail=''">Back to results</span>
                    </div>

                    <div class="border-t border-gray-200 px-4 py-5 sm:p-0 bg-white" >
                        <dl class="sm:divide-y sm:divide-gray-200 grid grid-cols-1 sm:grid-cols-2">

                                <template x-for="(value, field) in detail" :key="field">
{{--                                    <li x-text="color"></li>--}}
                                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 ">
                                        <dt class="text-sm font-medium text-gray-500 capitalize" x-text="prepareField(field)">

                                        </dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2" x-text="value">

                                        </dd>
                                    </div>

                                </template>

{{--                            @foreach($fields as $field)--}}
{{--                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">--}}
{{--                                    <dt class="text-sm font-medium text-gray-500">{{ __(ucfirst(str_replace('_', ' ', $field))) }}</dt>--}}
{{--                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">--}}
{{--                                        {{ $detail[$field] }}--}}
{{--                                    </dd>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}

{{--                            @if($detail->archive->id == 28)--}}
{{--                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">--}}
{{--                                    <dt class="text-sm font-medium text-gray-500">{{ __(ucfirst('Book Title')) }}</dt>--}}
{{--                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">--}}
{{--                                        {{ $detail->SwensonBookData->title }}--}}
{{--                                    </dd>--}}
{{--                                </div>--}}

{{--                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">--}}
{{--                                    <dt class="text-sm font-medium text-gray-500">{{ __(ucfirst('Author')) }}</dt>--}}
{{--                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">--}}
{{--                                        {{ $detail->SwensonBookData->author }}--}}
{{--                                    </dd>--}}
{{--                                </div>--}}

{{--                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">--}}
{{--                                    <dt class="text-sm font-medium text-gray-500">{{ __(ucfirst('Region')) }}</dt>--}}
{{--                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">--}}
{{--                                        {{ $detail->SwensonBookData->region }}--}}
{{--                                    </dd>--}}
{{--                                </div>--}}

{{--                                <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">--}}
{{--                                    <dt class="text-sm font-medium text-gray-500">{{ __(ucfirst('Publish date')) }}</dt>--}}
{{--                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">--}}
{{--                                        {{ $detail->SwensonBookData->publish_date }}--}}
{{--                                    </dd>--}}
{{--                                </div>--}}


{{--                            @endif--}}

                        </dl>

{{--                        @if(!empty($detail->user->organization))--}}
{{--                            <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">--}}
{{--                                <div>ID: {{ $detail->id }}</div>--}}
{{--                                <div>{{ __('Archive owner') }}: {{ $detail->user->organization->name }}</div>--}}
{{--                                <div>{{ __('Email') }}: {{ $detail->user->organization->email }}</div>--}}
{{--                                <div>{{ __('Telephone') }}: {{ $detail->user->organization->phone }}</div>--}}

{{--                            </div>--}}
{{--                        @endif--}}
{{--                        <div class="flex justify-end">--}}
{{--                            <a href="{{ route('records.print', ['arch'=> $detail->archive_id,'id'=>$detail->id]) }}"--}}
{{--                               class="inline-flex items-center rounded border border-transparent bg-indigo-600 px-2.5--}}
{{--                                    py-1.5 text-xs font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none--}}
{{--                                     focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2  mr-2 mt-2">--}}

{{--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">--}}
{{--                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />--}}
{{--                                </svg>--}}
{{--                                <span class="ml-1">{{ __('Print') }}</span>--}}
{{--                            </a>--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>
            {{ $records->appends(request()->except(['_token']))->links() }}
        </div>
    </div>
</div>

<script>
    function data() {
        return {
            openDetails: false,
            detail:'',
            next:'',

            prepareField(fieldName) {
                return fieldName.replaceAll('_', ' ');
            }
        }

    }
</script>


