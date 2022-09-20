<x-app-layout>
    <!-- Main 3 column grid -->
    @include('dashboard._breadcrumb')

    <div class="pt-6 grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->

        <div class="bg-white shadow overflow-hidden sm:rounded-lg px-4 py-5 sm:px-6">
            <div class="border-b border-gray-200">
                <div class="sm:items-baseline"  x-data="{ tab: 'details' }">

                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        {{ __('Archive') }}  <a href="{{ route('records.print', ['arch'=> $detail->archive_id,'id'=>$detail->id]) }}" >Print</a>
                    </p>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 flex">
                        {{ $archive_details->name }}
                    </h3>

                    <div class="flex pt-3">

                        @if(  !empty($detail->source_hfl_batch_number) &&  !empty($detail->source_hfl_image_number))
                            <a href="https://sok.riksarkivet.se/bildvisning/{{ $detail->source_hfl_batch_number }}_{{ $detail->source_hfl_image_number }}"
                               class="inline-flex items-center px-6 ml-2 py-1.5 border border-transparent text-xs font-medium
                            rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                               target="_blank">{{ __('Original hfl/fsb') }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @endif

                        @if(  !empty($detail->source_in_out_batch_number) && !empty($detail->source_in_out_image_number))
                            <a href="https://sok.riksarkivet.se/bildvisning/{{ $detail->source_in_out_batch_number }}_{{ $detail->source_in_out_image_number }}"
                               class="inline-flex items-center px-6 ml-2 py-1.5 border border-transparent text-xs font-medium
                            rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                               target="_blank">{{ __('Original flyttlängd') }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        @endif


                    </div>



                    <div class="-mt-8 ">
                        <nav class="-mb-px flex justify-end space-x-8">
                            <a class="text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm" :class="{ 'border-indigo-500 text-indigo-600 ': tab === 'details' }"
                               x-on:click.prevent="tab = 'details'"
                               href="#">{{ __('Details') }}</a>
{{--                            @if(empty($relatives))--}}
                            @if( $detail->relatives != null and $detail->relatives->count() > 0)
                            <a class="text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm" :class="{ 'border-indigo-500 text-indigo-600 ': tab === 'relatives' }"
                               x-on:click.prevent="tab = 'relatives'"
                               href="#">{{ __('Relatives') }}</a>
                            @endif

{{--                            @if(!$images->isEmpty())--}}
                            <a class=" text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm"
                               :class="{ ' border-indigo-500 text-indigo-600 ': tab === 'images' }" x-on:click.prevent="tab = 'images'"
                               href="#">Media</a>
{{--                            @endif--}}
                        </nav>
                    </div>
                    <div class="py-4">

                        <div  x-show="tab === 'details'">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 pb-4">Details</h3>

                            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                                <dl class="sm:divide-y sm:divide-gray-200 grid grid-cols-1 sm:grid-cols-2 striped">
                                    @foreach($fields as $field)
                                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">{{ __(ucfirst(str_replace('_', ' ', $field))) }}</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ $detail[$field] }}
                                            </dd>
                                        </div>
                                    @endforeach

                                        @if($detail->archive->id == 28)
                                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">{{ __(ucfirst('Book Title')) }}</dt>
                                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{ $detail->SwensonBookData->title }}
                                                </dd>
                                            </div>

                                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">{{ __(ucfirst('Author')) }}</dt>
                                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{ $detail->SwensonBookData->author }}
                                                </dd>
                                            </div>

                                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">{{ __(ucfirst('Region')) }}</dt>
                                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{ $detail->SwensonBookData->region }}
                                                </dd>
                                            </div>

                                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">{{ __(ucfirst('Publish date')) }}</dt>
                                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{ $detail->SwensonBookData->publish_date }}
                                                </dd>
                                            </div>


                                        @endif

                                </dl>

                                @if(!empty($detail->user->organization))
                                    <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                                            <div>ID: {{ $detail->id }}</div>
                                            <div>{{ __('Archive owner') }}: {{ $detail->user->organization->name }}</div>
                                            <div>{{ __('Email') }}: {{ $detail->user->organization->email }}</div>
                                            <div>{{ __('Telephone') }}: {{ $detail->user->organization->phone }}</div>

                                    </div>
                                @endif

                            </div>
                        </div>

                        @if( $detail->relatives != null and $detail->relatives->count() > 0)
                        <div  x-show="tab === 'relatives'">
                            <h3>Relatives</h3>
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
                                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $relative->first_name." ".$relative->last_name }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $relative->dob }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $relative->from_parish }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $relative->from_province }}</td>
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $relative->destination_country }}</td>
                                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                            <a href=" {{ route('records.show', ['arch'=> $relative['archive'],'id'=>$relative->id]) }} " class="text-indigo-600 hover:text-indigo-900">
                                                                Visa</a>
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

                        <div  x-show="tab === 'images'">
                            <h3>Media</h3>
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">

                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                            <iframe src="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url('archives/'.$archive_details->id.'/documents/'.$detail->file_name) }}"
                                                    style="width:100%; height:800px;" >
                                            </iframe>
{{--                                            <table class="min-w-full divide-y divide-gray-300">--}}
{{--                                                <thead class="bg-gray-50">--}}
{{--                                                <tr>--}}
{{--                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Context</th>--}}
{{--                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">link</th>--}}

{{--                                                </tr>--}}
{{--                                                </thead>--}}
{{--                                                <tbody class="bg-white">--}}
                                                <!-- Odd row -->
{{--                                                @foreach($images as $image)--}}
{{--                                                    <tr class="odd:bg-white even:bg-gray-100">--}}
{{--                                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $image->context }}--}}
{{--                                                            <img target="_blank" src="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($image->image_name) }}"--}}
{{--                                                                 class="h-10">--}}
{{--                                                        </td>--}}

{{--                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">--}}
{{--                                                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($image->image_name) }}"  class="text-indigo-600 hover:text-indigo-900">--}}
{{--                                                                View full image--}}
{{--                                                            </a>--}}

{{--                                                            <a  class="text-indigo-600 hover:text-indigo-900" target="_blank" href="{{ route('ImageCollections.show', $image->collection_id) }}">--}}
{{--                                                                View collection--}}
{{--                                                            </a>--}}

{{--                                                        </td>--}}

{{--                                                    </tr>--}}
{{--                                                @endforeach--}}


                                                <!-- More people... -->
{{--                                                </tbody>--}}
{{--                                            </table>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

