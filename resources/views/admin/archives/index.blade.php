<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <p class="mt-2 text-sm text-gray-700">A list of all available archives</p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href=" {{ route('admin.categories.index') }}"
                   type="button" class="inline-flex items-center justify-center rounded-md border
                border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm
                hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500
                focus:ring-offset-2 sm:w-auto">Go to category</a>
            </div>
        </div>
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900
                                sm:pl-6">Archive Title</th>

                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">

                            @foreach($archives as $archive)
                                <tr>
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900
                                    sm:pl-6">{{ $archive->name }} <span class="inline-flex items-center px-3 py-0.5
                                    rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            Organizations: {{ $archive->organizations->count() }}
                                        </span>

                                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm
                                        font-medium bg-green-100 text-green-800"> Category: {{ $archive->category->name }} </span>

                                    </td>
                                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium
                                     sm:pr-6">


                                        @hasanyrole('emiweb admin|emiweb staff')
                                        <a href="{{ route('emiweb.archives.show', $archive) }}" type="button"
                                           class="inline-flex items-center px-3 py-1.5
                                         text-indigo-600 ">Show Archive</a>
                                        @endhasanyrole

                                        @hasanyrole('super admin')
                                        <a href="{{ route('admin.archives.show', $archive) }}" type="button"
                                           class="inline-flex items-center px-3 py-1.5
                                         text-indigo-600 ">Show Archive</a>

                                        <a href="{{ route('admin.archives.edit', $archive) }}" type="button"
                                           class="inline-flex items-center px-3 py-1.5 border
                                         border-transparent text-xs font-medium rounded-md shadow-sm
                                         text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                                         focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Edit Archive</a>
                                        @endhasanyrole

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


    <!-- This example requires Tailwind CSS v2.0+ -->



</x-admin-layout>
