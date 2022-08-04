<x-app-layout>
    <!-- Main 3 column grid -->
    {{ __('Hem') }} /  {{ $archive->name  }} / {{ $detail->first_name }} {{ $detail->last_name }}
    <div class="grid pt-6 grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->

        <div class="bg-white shadow overflow-hidden sm:rounded-lg px-4 py-5 sm:px-6">
            <div class="border-b border-gray-200">
                <div class="sm:items-baseline"  x-data="{ tab: 'details' }">

                        <h3 class="text-lg leading-6 font-medium text-gray-900 flex">{{ __('Archive name') }}

                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $archive->name }}</p>
                        <div class="flex pt-3">
                            <a href="{{ route('organizations.archives.record.edit', ['organization'=> auth()->user()->organization,'archive'=>$detail->archive->id, 'record'=> $detail->id]) }}"
                            class="inline-flex items-center px-6 mr-2 py-1.5 border border-transparent text-xs font-medium
                            rounded-full shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                            focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Edit record') }}</a>
                            <div x-data="{ person: 'archives/{{ $archive->id }}/records/{{ $detail->id }}'}"
                            class=" inline-flex items-center px-3 ml-2 py-1.5 border-2 bor border-indigo-600 text-xs font-medium
                             rounded-full shadow-sm text-indigo-600 bg-white  hover:bg-indigo-700 hover:text-white focus:outline-none
                             focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <div @click="$clipboard(person)"  class="flex items-center cursor-pointer">
                                    <svg  xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                    </svg>
                                    <span>
                                        {{ __('Copy Link') }}
                                    </span>

                                </div>

                            </div>
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
                               href="#">Details</a>
                            <a class="text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm" :class="{ 'border-indigo-500 text-indigo-600 ': tab === 'relatives' }"
                               x-on:click.prevent="tab = 'relatives'"
                               href="#">Relatives</a>
                            <a class=" text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm"
                               :class="{ ' border-indigo-500 text-indigo-600 ': tab === 'documents' }" x-on:click.prevent="tab = 'documents'"
                               href="#">Documents</a>
                            <a class=" text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm"
                               :class="{ ' border-indigo-500 text-indigo-600 ': tab === 'images' }" x-on:click.prevent="tab = 'images'"
                               href="#">Images</a>
                        </nav>
                    </div>
                    <div class="py-4">

                        <div  x-show="tab === 'details'">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 pb-4">Details</h3>

                            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                                <dl class="sm:divide-y sm:divide-gray-200 grid grid-cols-1 sm:grid-cols-2">
                                    @foreach($fields as $field)
                                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">{{ __(ucfirst(str_replace('_', ' ', $field))) }}</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ $detail[$field] }}
                                            </dd>
                                        </div>
                                    @endforeach


                                </dl>
                            </div>
                        </div>

                        <div  x-show="tab === 'relatives'">
                            <h3>Relatives</h3>
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                        {!! Form::open(['route' => ['relatives.create',$archive, $detail->id]]) !!}
                                        <div class="flex pb-4">

                                            {{ Form::text('relative_info',null,
                                                                   ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                                   sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                                   'id' => 'relative_info']) }}

                                            {{ Form::text('relationship_type',null,
                                                                   ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                                   sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                                   'id' => 'relationship_type']) }}

                                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent
                                                                 shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                                                                 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Relationship
                                            </button>

                                        </div>
                                        {!! Form::close() !!}
                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ __('Full name') }}</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Birth place') }}</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Relationship') }}</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Last resident') }}</th>
                                                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                                        <span class="sr-only">{{ __('View') }}</span>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                <!-- Odd row -->
                                                @foreach($relatives as $relative)
                                                <tr class="odd:bg-white even:bg-gray-100">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $relative->full_name }}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $relative->relationship }}</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"></td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                        <a href=" {{ route('records.show', ['arch'=> $relative->archive,'id'=>$relative->item_id]) }} " class="text-indigo-600 hover:text-indigo-900">
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
                        <div  x-show="tab === 'documents'">
                            <h3>Documents</h3>
                            <div>

                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4
                                            0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0
                                             015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2"
                                                  stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>

                                        <div class="flex text-sm text-gray-600">
                                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md
                                            font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none
                                            focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload documents</span>
                                                <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, PDF </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div  x-show="tab === 'images'">
                            <h3>Images</h3>
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                        {!! Form::open(['route' => ['record.image',$archive, $detail->id]]) !!}
                                        <div class="flex pb-4">

                                            {{ Form::text('image_name',null,
                                                                   ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                                   sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                                   'id' => 'first_name']) }}

                                            <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent
                                                                 shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700
                                                                 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Attach image data
                                            </button>

                                        </div>
                                        {!! Form::close() !!}
                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
                                             >
                                            <div class="grid grid-cols-5 gap-6" >
                                                @foreach($images as $image)


                                                    <img x-lightbox="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($image->image_name) }}"
                                                         src="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($image->image_name) }}">

{{--                                                    <img src="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($image->image_name) }}">--}}



                                                @endforeach
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

    </div>
</x-app-layout>
