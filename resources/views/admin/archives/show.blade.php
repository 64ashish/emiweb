<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">Archive: {{ $archive->name }}</h1>
            </div>

        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-5">

            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Location Information</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $archive->place }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Associated Category</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $archive->category->name }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Category Detail</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{!! $archive->detail !!} </dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Organizations with access to this archives</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
{{--                            <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">--}}
{{--                                @foreach($category->archive as $archive)--}}
{{--                                    <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">--}}
{{--                                        <div class="w-0 flex-1 flex items-center">--}}
{{--                                            <span class="ml-2 flex-1 w-0 truncate"> {{ $archive->name }} </span>--}}
{{--                                        </div>--}}
{{--                                        <div class="ml-4 flex-shrink-0">--}}
{{--                                            <a href="{{ route('admin.archives.show', $category) }}" class="inline-flex items-center px-3 py-1.5 border--}}
{{--                                         border-transparent text-xs font-medium rounded-full shadow-sm--}}
{{--                                         text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none--}}
{{--                                         focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> Edit Archive </a>--}}
{{--                                        </div>--}}
{{--                                        <div class="ml-4 flex-shrink-0">--}}
{{--                                            <a href="{{ route('admin.archives.show', $category) }}" class="inline-flex items-center px-3 py-1.5 border--}}
{{--                                         border-transparent text-xs font-medium rounded-full shadow-sm--}}
{{--                                         text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none--}}
{{--                                         focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"> View Archive </a>--}}
{{--                                        </div>--}}
{{--                                    </li>--}}
{{--                                @endforeach--}}

{{--                            </ul>--}}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-admin-layout>
