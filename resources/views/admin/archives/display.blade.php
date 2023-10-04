<x-admin-layout>
    <div class="flex justify-content-end">
        <div class="mt-4 sm:mt-0 sm:ml-16">
            <a href=" {{ route('admin.archives.index') }}"
               type="button" class="inline-flex items-center justify-center rounded-md border
            border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm
            hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500
            focus:ring-offset-2 sm:w-auto">Go to Archive</a>
        </div>
    </div>
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <div class="grid grid-cols-1 gap-4 lg:col-span-2">
            <section aria-labelledby="section-1-title">
                <div>
                    <div class="pb-6">
                        <ul role="list">
                            @foreach( $catArchives as $category)
                                <li>
                                    <h2 class="text-x1 font-medium text-black-900 px-6 py-4">{{ __($category->name) }}</h2>
                                    <ul class="rounded-lg bg-white overflow-hidden shadow">
                                        @foreach($category->archives as $archive)
                                            <li class="odd:bg-white even:bg-gray-100 px-6 py-2">
                                                <div class="flex justify-between">
                                                    <div class="flex items-center">
                                                        <div class="pr-2 font-bold">
                                                            @if($archive->total_records > 0)
                                                            <a href="{{ route('records', $archive) }}"> {{ __($archive->name) }}</a>
                                                            @else
                                                            {{ __($archive->name) }}
                                                            @endif
                                                        </div>
                                                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                            {{ number_format($archive->total_records)}}
                                                            {{ __('Records') }}
                                                        </span>
                                                    </div>

                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-admin-layout>