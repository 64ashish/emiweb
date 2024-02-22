<x-app-layout>
    <!-- Main 3 column grid -->
    @include('dashboard._breadcrumb')

    <div class="pt-6 grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->

        <div class="bg-white shadow overflow-hidden sm:rounded-lg px-4 py-5 sm:px-6">
            <div class="border-b border-gray-200">
                <div class="sm:items-baseline" x-data="{ tab: 'details' }">

                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        {{ __('Archive') }}
                    </p>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 flex">
                        {{ __($archive_details->name) }}
                    </h3>

                    <div class="flex pt-3">
                        @if( !empty($detail->source_hfl_batch_number) && !empty($detail->source_hfl_image_number))
                        <a href="https://sok.riksarkivet.se/bildvisning/{{ $detail->source_hfl_batch_number }}_{{ $detail->source_hfl_image_number }}" class="inline-flex items-center px-6 ml-2 py-1.5 border border-transparent text-xs font-medium
                            rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" target="_blank">{{ __('Original hfl/fsb') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                        @endif

                        @if( !empty($detail->source_in_out_batch_number) && !empty($detail->source_in_out_image_number))
                        <a href="https://sok.riksarkivet.se/bildvisning/{{ $detail->source_in_out_batch_number }}_{{ $detail->source_in_out_image_number }}" class="inline-flex items-center px-6 ml-2 py-1.5 border border-transparent text-xs font-medium
                            rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" target="_blank">{{ __('Original flyttlängd') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                        @endif
                        @if(!is_null($detail->riksarkivet))
                        <a href="https://sok.riksarkivet.se/bildvisning/{{ $detail->riksarkivet }}" class="inline-flex items-center px-6 ml-2 py-1.5 border border-transparent text-xs font-medium
                            rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" target="_blank">{{ __('Original dokument') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                        @endif

                        @if( !empty($detail->svar_batch_number) && !empty($detail->svar_image_number))
                        <a href="https://sok.riksarkivet.se/bildvisning/{{ $detail->svar_batch_number }}_{{ $detail->svar_image_number }}" class="inline-flex items-center px-6 ml-2 py-1.5 border border-transparent text-xs font-medium
                            rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" target="_blank">{{ __('Original dokument') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                        @endif

                        @if( !empty($detail->svar_batch_nr) && !empty($detail->svar_image_nr))
                        <a href="https://sok.riksarkivet.se/bildvisning/{{ $detail->svar_batch_nr }}_{{ $detail->svar_image_nr }}" class="inline-flex items-center px-6 ml-2 py-1.5 border border-transparent text-xs font-medium
                            rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" target="_blank">{{ __('Original dokument') }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                        @endif


                    </div>



                    <div class="-mt-8 ">
                        <nav class="-mb-px flex justify-end space-x-8">
                            <a href="javascript:void(0)" onclick="previousrecord({{ isset($detail->archive_id) ? $detail->archive_id : '' }},{{ isset($detail->id) ? $detail->id : '' }})" class="relative -ml-px inline-flex items-center border border-gray-300 bg-white px-4 py-4  text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" id="previousRecord">
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                                </svg>
                                {{ __('Previous record') }}
                                <input type="hidden" name="record_id" id="record_id_current" value="{{ isset($detail->id) ? $detail->id : '' }}">
                            </a>

                            <a href="javascript:void(0)" onclick="nextrecord({{ isset($detail->archive_id) ? $detail->archive_id : '' }},{{ isset($detail->id) ? $detail->id : '' }})" class="relative -ml-px inline-flex items-center  border border-gray-300 bg-white px-4 py-4  text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" id="nextRecord">{{ __('Next record') }}
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a class="text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2 hover:text-indigo-700 hover:border-indigo-700
                            font-medium text-sm" :class="{ 'border-indigo-700 text-indigo-700 ': tab === 'details' }" x-on:click.prevent="tab = 'details'" href="#">

                                {{ __('Details') }}</a>
                            {{-- @if(empty($relatives))--}}
                            @if( $detail->relatives != null and $detail->relatives->count() > 0)
                            <a class="text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2 hover:text-indigo-700 hover:border-indigo-700
                            font-medium text-sm" :class="{ 'border-indigo-700 text-indigo-700 ': tab === 'relatives' }" x-on:click.prevent="tab = 'relatives'" href="#">{{ __('Relatives') }}</a>
                            @endif

                            @if( isset($detail->links['Immigrants in Swedish church records']) or isset($detail->links['Emigrants in Swedish church records']))
                            <a class="text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2 hover:text-indigo-700 hover:border-indigo-700
                            font-medium text-sm" :class="{ 'border-indigo-700 text-indigo-700 ': tab === 'links' }" x-on:click.prevent="tab = 'links'" href="#">{{ __('Links') }}</a>
                            @endif

                            @if($media != false)
                            <a class=" text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm" :class="{ ' border-indigo-700 text-indigo-700 ': tab === 'images' }" x-on:click.prevent="tab = 'images'" href="#">{{ __('Media') }}</a>
                            @endif

                            @if($detail->archive_id == "22" && count($detail->activities) > 0)
                            <a class=" text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm" :class="{ ' border-indigo-700 text-indigo-700 ': tab === 'activities' }" x-on:click.prevent="tab = 'activities'" href="#">{{ __('Activities') }}</a>
                            @endif

                        </nav>
                    </div>
                    <div class="py-4">

                        <div x-show="tab === 'details'">
                            <div class="pb-4 flex flex-row al">
                                <div class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                                    {{ __('Details') }}

                                </div>
                                <div class="">
                                    <a href="{{ route('records.print', ['arch'=> $detail->archive_id,'id'=>$detail->id]) }}" class="inline-flex items-center rounded border border-transparent bg-indigo-600 px-2.5
                                    py-1.5 text-xs font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none
                                     focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2  ml-2 ">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                        </svg>
                                        <span class="ml-1">{{ __('Print') }}</span>
                                    </a>
                                </div>
                            </div>


                            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                                <dl class="sm:divide-y sm:divide-gray-200 grid grid-cols-1 sm:grid-cols-2 striped">
                                    @foreach($fields as $field)
                                    <div class=" sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-500">{{ __(ucfirst(str_replace('_', ' ', $field))) }}</dt>
                                        <dd class="mt-1 text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $detail[$field] }}
                                        </dd>
                                    </div>
                                    @endforeach

                                    @if($detail->archive->id == 28)
                                    <div class=" sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-500">{{ __(ucfirst('Book Title')) }}</dt>
                                        <dd class="text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem] text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $detail->SwensonBookData->title }}
                                        </dd>
                                    </div>

                                    <div class=" sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem] font-medium text-gray-500">{{ __(ucfirst('Author')) }}</dt>
                                        <dd class="mt-1 text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $detail->SwensonBookData->author }}
                                        </dd>
                                    </div>

                                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-500">{{ __(ucfirst('Region')) }}</dt>
                                        <dd class="mt-1 text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem] text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $detail->SwensonBookData->region }}
                                        </dd>
                                    </div>

                                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-sm font-medium text-gray-500">{{ __(ucfirst('Publish date')) }}</dt>
                                        <dd class="mt-1 text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $detail->SwensonBookData->publish_date }}
                                        </dd>
                                    </div>


                                    @endif



                                </dl>

                                @if($detail->archive_id == "22" && count($detail->professions) > 0)
                                <div class="col-span-2 py-6">
                                    <hr>
                                </div>
                                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>

                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Profession') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Industry') }}</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Branch') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white">
                                            <!-- Odd row -->
                                            @foreach($detail->professions as $profession)
                                            {{-- {{ $profession }}--}}
                                            <tr class="odd:bg-white even:bg-gray-100">

                                                <td class="whitespace-nowrap px-3  py-[0.6rem]  text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-500">{{ $profession->profession }}</td>
                                                <td class="whitespace-nowrap px-3   py-[0.6rem] text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-500">{{ $profession->industry }}</td>
                                                <td class="whitespace-nowrap px-3 py-[0.6rem]  text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-500">{{ $profession->branch }}</td>
                                            </tr>
                                            @endforeach

                                            <!-- More people... -->
                                        </tbody>
                                    </table>
                                </div>
                                @endif

                                @if(!empty($detail->user->organization))
                                <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6 text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem] ">
                                    <div>ID: {{ $detail->id }}</div>
                                    <div>{{ __('Archive owner') }}: {{ $detail->user->organization->name }}</div>
                                    <div>{{ __('Email') }}: {{ $detail->user->organization->email }}</div>
                                    <div>{{ __('Telephone') }}: {{ $detail->user->organization->phone }}</div>

                                </div>
                                @endif
                                <div class="flex justify-end">
                                    <a href="{{ route('records.print', ['arch'=> $detail->archive_id,'id'=>$detail->id]) }}" class="inline-flex items-center rounded border border-transparent bg-indigo-600 px-2.5
                                    py-1.5 text-xs font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none
                                     focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2  mr-2 mt-2">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                                        </svg>
                                        <span class="ml-1">{{ __('Print') }}</span>
                                    </a>
                                </div>

                            </div>

                        </div>

                        @if($detail->archive_id == "22" && count($detail->activities) > 0)
                        <div x-show="tab === 'activities'">
                            <h3>{{ __('Activities') }}</h3>
                            <div>

                                @foreach($detail->activities as $activity)
                                <dl class="sm:divide-y sm:divide-gray-200 grid grid-cols-1 sm:grid-cols-2 striped">
                                    <div class=" sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-500">{{ __('Activity') }}</dt>
                                        <dd class="mt-1 text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $activity->activity  }}
                                        </dd>
                                    </div>

                                    <div class=" sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-500">{{ __('Type') }}</dt>
                                        <dd class="mt-1 text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $activity->type  }}
                                        </dd>
                                    </div>

                                    <div class=" sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-500">{{ __('Duration') }}</dt>
                                        <dd class="mt-1 text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $activity->duration  }}
                                        </dd>
                                    </div>

                                    <div class=" sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-500">{{ __('Time period') }}</dt>
                                        <dd class="mt-1 text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $activity->time_period  }}
                                        </dd>
                                    </div>

                                    <div class=" sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-500">{{ __('Country') }}</dt>
                                        <dd class="mt-1 text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $activity->country  }}
                                        </dd>
                                    </div>

                                    <div class=" sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-500">{{ __('Location') }}</dt>
                                        <dd class="mt-1 text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $activity->location  }}
                                        </dd>
                                    </div>

                                    <div class=" sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                        <dt class="text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-500">{{ __('Comments') }}</dt>
                                        <dd class="mt-1 text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-900 sm:mt-0 sm:col-span-2">
                                            {{ $activity->comments  }}
                                        </dd>
                                    </div>
                                </dl>
                                <div class="col-span-2 py-6">
                                    <hr>
                                </div>
                                @endforeach

                            </div>
                        </div>
                        @endif

                        @if( $detail->relatives != null and $detail->relatives->count() > 0)
                        <div x-show="tab === 'relatives'">
                            <h3>{{ __('Relatives') }}</h3>
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ __('Full name') }}</th>
                                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Birth date') }}</th>
                                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('From parish') }}</th>
                                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('From province') }}</th>
                                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Destination') }}</th>
                                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                            <span class="sr-only">{{ __('View') }}</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                    <!-- Odd row -->
                                                    @foreach($detail->relatives as $relative)
                                                    <tr class="odd:bg-white even:bg-gray-100">
                                                        <td class="whitespace-nowrap  pr-3  py-[0.6rem] text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-900 sm:pl-6">{{ $relative->first_name." ".$relative->last_name }}</td>
                                                        <td class="whitespace-nowrap px-3   py-[0.6rem] text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-500">{{ $relative->dob }}</td>
                                                        <td class="whitespace-nowrap px-3 py-[0.6rem]  text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-500">{{ $relative->from_parish }}</td>
                                                        <td class="whitespace-nowrap px-3  py-[0.6rem]  text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-500">{{ $relative->from_province }}</td>
                                                        <td class="whitespace-nowrap px-3  py-[0.6rem]  text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  text-gray-500">{{ $relative->destination_country }}</td>
                                                        <td class="relative whitespace-nowrap  py-[0.6rem]  pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                            <a href=" {{ route('records.show', ['arch'=> $relative['archive'],'id'=>$relative->id]) }} " class="text-indigo-600 hover:text-indigo-900">
                                                                {{ __('Show') }}</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                    <!-- More people... -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if( isset($detail->links['Immigrants in Swedish church records']) or isset($detail->links['Emigrants in Swedish church records']))

                        <div x-show="tab === 'links'">

                            <h3 class="text-lg leading-6 font-medium text-gray-900 flex items-center">{{ __('Links') }}</h3>
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                    <tr>
                                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ __('Archive') }}</th>

                                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                            <span class="sr-only">{{ __('View') }}</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                    <!-- Odd row -->
                                                    @if( isset($detail->links['Immigrants in Swedish church records']) and $detail->links['Immigrants in Swedish church records'] != null)
                                                    <tr class="odd:bg-white even:bg-gray-100">
                                                        <td class="whitespace-nowrap  pr-3  py-[0.6rem] text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-900 sm:pl-6">{{ __('Immigrants in Swedish church records') }}</td>

                                                        <td class="relative whitespace-nowrap  py-[0.6rem]  pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                            <a href=" {{ route('records.show', ['arch'=> '6','id'=>$detail->links['Immigrants in Swedish church records']['id']]) }} " class="text-indigo-600 hover:text-indigo-900">
                                                                {{ __('Show') }}</a>
                                                        </td>
                                                    </tr>
                                                    @endif

                                                    @if( isset($detail->links['Emigrants in Swedish church records']) and $detail->links['Emigrants in Swedish church records'] != null)
                                                    <tr class="odd:bg-white even:bg-gray-100">
                                                        <td class="whitespace-nowrap  pr-3  py-[0.6rem] text-[0.85rem] leading-[0.9rem] sm:py-[0.6rem]  font-medium text-gray-900 sm:pl-6">{{ __('Emigrants in Swedish church records') }}</td>

                                                        <td class="relative whitespace-nowrap  py-[0.6rem]  pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                            <a href=" {{ route('records.show', ['arch'=> '5','id'=>$detail->links['Emigrants in Swedish church records']['id']]) }} " class="text-indigo-600 hover:text-indigo-900">
                                                                {{ __('Show') }}</a>
                                                        </td>
                                                    </tr>
                                                    @endif

                                                    <!-- More people... -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif



                        @if($media != false)
                        <div x-show="tab === 'images'">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 pb-4 flex items-center  border-b border-gray-200 ">

                                Media
                            </h3>
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">

                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">

                                            @if(in_array(pathinfo($media, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'svg', 'JPG']))
                                            <img src="{{ $media }}">
                                            @else
                                            <iframe src="{{ $media }}" style="width:100%; height:800px;">
                                            </iframe>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif




                    </div>
                </div>
            </div>
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script>
        $(document).ready(function() {
            var retrievedArrayString = sessionStorage.getItem('recordArray');
            var numberArray = JSON.parse(retrievedArrayString);
            const id = {
                {
                    isset($detail - > id) ? $detail - > id : ''
                }
            };
            var record_key = numberArray.indexOf(id);
            if (record_key <= 0) {
                $('#previousRecord').attr('style', 'display: none !important;');
            }

            if (record_key >= 99) {
                $('#nextRecord').attr('style', 'display: none !important;');
            }
        });

        function previousrecord(archive_id, id) {
            var retrievedArrayString = sessionStorage.getItem('recordArray');
            var numberArray = JSON.parse(retrievedArrayString);

            var record_key = numberArray.indexOf(id);
            record_key = record_key - 1;

            var new_id = numberArray[record_key];

            window.location.href = "/records/" + archive_id + "/" + new_id + '?' + record_key
        }

        function nextrecord(archive_id, id) {
            var retrievedArrayString = sessionStorage.getItem('recordArray');
            var numberArray = JSON.parse(retrievedArrayString);

            var record_key = numberArray.indexOf(id);
            record_key = record_key + 1;

            var new_id = numberArray[record_key];

            window.location.href = "/records/" + archive_id + "/" + new_id + '?' + record_key
        }
    </script>
</x-app-layout>