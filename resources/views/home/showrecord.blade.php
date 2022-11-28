<x-app-layout>
    <!-- Main 3 column grid -->
    @include('dashboard._breadcrumb')

    <div class="pt-6 grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->

        <div class="bg-white shadow overflow-hidden sm:rounded-lg px-4 py-5 sm:px-6">
            <div class="border-b border-gray-200">
                <div class="sm:items-baseline"  x-data="{ tab: 'details' }">

                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        {{ __('Archive') }}
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
                               href="#">

                                {{ __('Details') }}</a>
{{--                            @if(empty($relatives))--}}
                            @if( $detail->relatives != null and $detail->relatives->count() > 0)
                            <a class="text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm" :class="{ 'border-indigo-500 text-indigo-600 ': tab === 'relatives' }"
                               x-on:click.prevent="tab = 'relatives'"
                               href="#">{{ __('Relatives') }}</a>
                            @endif

                            @if($media != false)
                            <a class=" text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm"
                               :class="{ ' border-indigo-500 text-indigo-600 ': tab === 'images' }" x-on:click.prevent="tab = 'images'"
                               href="#">Media</a>
                            @endif
                            <a class=" text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm"
                               :class="{ ' border-indigo-500 text-indigo-600 ': tab === 'message' }" x-on:click.prevent="tab = 'message'"
                               href="#">Message</a>
                        </nav>
                    </div>
                    <div class="py-4">

                        <div  x-show="tab === 'details'">
                            <div class="pb-4 flex flex-row al">
                                <div class="text-lg leading-6 font-medium text-gray-900 flex items-center">
                                    {{ __('Details') }}

                                </div>
                                <div class="">
                                    <a href="{{ route('records.print', ['arch'=> $detail->archive_id,'id'=>$detail->id]) }}"
                                       class="inline-flex items-center rounded border border-transparent bg-indigo-600 px-2.5
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
                                <div class="flex justify-end">
                                    <a href="{{ route('records.print', ['arch'=> $detail->archive_id,'id'=>$detail->id]) }}"
                                       class="inline-flex items-center rounded border border-transparent bg-indigo-600 px-2.5
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
                        @if($media != false)
                        <div  x-show="tab === 'images'">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 pb-4 flex items-center  border-b border-gray-200 ">

                                Media
                            </h3>
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">

                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                            <iframe src="{{ $media }}"
                                                    style="width:100%; height:800px;" >
                                            </iframe>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div  x-show="tab === 'message'">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 pb-4 flex items-center  border-b border-gray-200 ">

                                Message
                            </h3>
                            <div class="flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">

                                        <div class=" md:rounded-lg">
                                            {!! Form::open(['route' => 'suggestion']) !!}

                                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:py-5">
                                                    <label for="subject"
                                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                        Subject
                                                    </label>
                                                    <div class="mt-1 sm:mt-0 sm:col-span-2">

                                                        {!! Form::text('subject', null,
                                                                ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                                sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                                'id' => 'Subject']) !!}
                                                        @error('subject')
                                                        <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                                        </p>@enderror
                                                    </div>
                                                </div>

                                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
                                                <label for="email"
                                                       class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                    Email </label>
                                                <div class="mt-1 sm:mt-0 sm:col-span-2">

                                                    {!! Form::text('email', null,
                                                            ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                            sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                            'id' => 'email']) !!}
                                                    @error('email')
                                                    <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                                    </p>@enderror
                                                </div>
                                            </div>

                                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
                                                    <label for="message"
                                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                        Message</label>
                                                    <div class="mt-1 sm:mt-0 sm:col-span-2">

                                                        {!! Form::textarea('message', null,
                                                                ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                                sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                                'id' => 'message']) !!}
                                                        @error('message')
                                                        <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                                        </p>@enderror
                                                    </div>
                                                </div>

                                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
                                                    <label for="archive"
                                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                        Archive </label>
                                                    <div class="mt-1 sm:mt-0 sm:col-span-2">

                                                        {!! Form::text('archive',$archive_details->name ,
                                                                ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                                sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                                'id' => 'archive', 'readonly']) !!}
                                                        @error('archive')
                                                        <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                                        </p>@enderror
                                                    </div>
                                                </div>

                                                <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
                                                    <label for="record"
                                                           class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                                        Record id</label>
                                                    <div class="mt-1 sm:mt-0 sm:col-span-2">

                                                        {!! Form::text('record', $archive_details->id,
                                                                ['class' => 'max-w-lg disabled block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                                sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                                'id' => 'record', 'readonly']) !!}
                                                        @error('record')
                                                        <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                                        </p>@enderror
                                                    </div>
                                                </div>

                                                <div class="sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5 flex justify-end">
                                                    {!! Form::hidden('record_url',url()->current(),['readonly']) !!}
                                                   <button type="submit"  class=" inline-flex items-center px-8 py-2 border
                                                       border-transparent text-base font-medium rounded-md shadow-sm text-white
                                                       {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }} hover:bg-indigo-700 focus:outline-none focus:ring-2
                                                       focus:ring-offset-2 focus:ring-indigo-500">{{ __('Send') }}
                                                   </button>
                                               </div>


                                           {!! Form::close() !!}

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

