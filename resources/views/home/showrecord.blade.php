<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->

        <div class="bg-white shadow overflow-hidden sm:rounded-lg px-4 py-5 sm:px-6">
            <div class="border-b border-gray-200">
                <div class="sm:items-baseline"  x-data="{ tab: 'details' }">

                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        {{ __('Archive') }}
                    </p>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 flex">
                        {{ $detail->archive->name }}
                    </h3>



                    <div class="-mt-8 ">
                        <nav class="-mb-px flex justify-end space-x-8">
                            <a class="text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm" :class="{ 'border-indigo-500 text-indigo-600 ': tab === 'details' }"
                               x-on:click.prevent="tab = 'details'"
                               href="#">Details</a>
{{--                            @if(empty($relatives))--}}
                            @if(!$relatives->isEmpty())
                            <a class="text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm" :class="{ 'border-indigo-500 text-indigo-600 ': tab === 'relatives' }"
                               x-on:click.prevent="tab = 'relatives'"
                               href="#">Relatives</a>
                            @endif

                            @if(!$images->isEmpty())
                            <a class=" text-gray-500  whitespace-nowrap pb-4 px-1 border-b-2
                            font-medium text-sm"
                               :class="{ ' border-indigo-500 text-indigo-600 ': tab === 'images' }" x-on:click.prevent="tab = 'images'"
                               href="#">Media</a>
                            @endif
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
                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ __('Full name') }}</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">{{ __('Relationship') }}</th>
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
                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $relative->relationship_type }}</td>
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

                        <div  x-show="tab === 'images'">
                            <h3>Media</h3>
                            <div class="mt-8 flex flex-col">
                                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">

                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Context</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">link</th>

                                                </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                <!-- Odd row -->
                                                @foreach($images as $image)
                                                    <tr class="odd:bg-white even:bg-gray-100">
                                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">{{ $image->context }}
                                                            <img target="_blank" src="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($image->image_name) }}"
                                                                 class="h-10">
                                                        </td>

                                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                            <a href="{{ \Illuminate\Support\Facades\Storage::disk('s3')->url($image->image_name) }}"  class="text-indigo-600 hover:text-indigo-900">
                                                                View full image
                                                            </a>

                                                            <a  class="text-indigo-600 hover:text-indigo-900" target="_blank" href="{{ route('ImageCollections.show', $image->collection_id) }}">
                                                                View collection
                                                            </a>

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
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

