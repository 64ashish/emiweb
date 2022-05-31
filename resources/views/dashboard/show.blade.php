<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Archive name') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $archive->name }}</p>
            </div>
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

        <div class="bg-white shadow overflow-hidden sm:rounded-lg px-4 py-5 sm:px-6">
            <div class="border-b border-gray-200">
                <div class="sm:items-baseline"  x-data="{ tab: 'relatives' }">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 pb-4">Related Records and Files</h3>
                    <div class="mt-4 ">
                        <nav class="-mb-px flex space-x-8">
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
                                                <tr class="odd:bg-white even:bg-gray-100">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Jane Doe</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Malmö</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Mother</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Malmö</td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Visa</a>
                                                    </td>
                                                </tr>
                                                <tr class="odd:bg-white even:bg-gray-100">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Jane Doe</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Malmö</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Mother</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Malmö</td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Visa</a>
                                                    </td>
                                                </tr>
                                                <tr class="odd:bg-white even:bg-gray-100">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Jane Doe</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Malmö</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Mother</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Malmö</td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Visa</a>
                                                    </td>
                                                </tr>
                                                <tr class="odd:bg-white even:bg-gray-100">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Jane Doe</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Malmö</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Mother</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Malmö</td>
                                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                        <a href="#" class="text-indigo-600 hover:text-indigo-900">Visa</a>
                                                    </td>
                                                </tr>

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
                                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                            <table class="min-w-full divide-y divide-gray-300">
                                                <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Archive name</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Found on page</th>
                                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">link</th>

                                                </tr>
                                                </thead>
                                                <tbody class="bg-white">
                                                <!-- Odd row -->
                                                <tr class="odd:bg-white even:bg-gray-100">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Jane Doe</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">3</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">view</td>

                                                </tr>
                                                <tr class="odd:bg-white even:bg-gray-100">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Jane Doe</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">3</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">view</td>

                                                </tr>
                                                <tr class="odd:bg-white even:bg-gray-100">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Jane Doe</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">3</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">view</td>

                                                </tr>
                                                <tr class="odd:bg-white even:bg-gray-100">
                                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">Jane Doe</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">3</td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">view</td>
                                                </tr>

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
