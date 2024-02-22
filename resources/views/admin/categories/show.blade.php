<x-admin-layout>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-xl font-semibold text-gray-900">{{ sprintf(__('Category: %s'), $category->name) }}</h1>
            </div>

        </div>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mt-5">

            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl class="sm:divide-y sm:divide-gray-200">
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Location Information') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $category->place }}</dd>
                    </div>
                    <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">{{ __('Archives Associated with this category') }}</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <ul role="list" class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                @foreach($category->archives as $archive)
                                <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                    <div class="w-0 flex-1 flex items-center">
                                        <span class="ml-2 flex-1 w-0 truncate"> {{ $archive->name }} </span>
                                    </div>
                                    @hasanyrole('super admin')
                                    <div class="ml-4 flex-shrink-0">
                                        <a href="{{ route('admin.archives.show', $archive) }}" class="inline-flex items-center px-3 py-1.5 border
                                         border-transparent text-xs font-medium rounded-md shadow-sm
                                         text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                                         focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Edit Archive') }} </a>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                        <a href="{{ route('admin.archives.edit', $category) }}" class="inline-flex items-center px-3 py-1.5 border
                                         border-transparent text-xs font-medium rounded-md shadow-sm
                                         text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                                         focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('View Archive') }} </a>
                                    </div>
                                    @endhasanyrole

                                    @hasanyrole('emiweb admin|emiweb staff')

                                    <div class="ml-4 flex-shrink-0">
                                        <a href="{{ route('emiweb.archives.show', $category) }}" class="inline-flex items-center px-3 py-1.5 border
                                         border-transparent text-xs font-medium rounded-md shadow-sm
                                         text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none
                                         focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('View Archive') }} </a>
                                    </div>
                                    @endhasanyrole
                                </li>
                                @endforeach

                            </ul>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-admin-layout>