<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <div class="grid grid-cols-1 gap-4 lg:col-span-2">
            <section aria-labelledby="section-1-title">

                <div >
                    <div class="pb-6">
                        <ul role="list">

                            @if(auth()->user()->hasRole('regular user'))
                                <li>
                                    <p class="text-sm font-medium text-black-900 px-6 py-4">{{ $catArchives->name }}</p>
                                    <ul class="rounded-lg bg-white overflow-hidden shadow">
                                        @foreach($catArchives->archives->where('id',1) as $archive)
                                            <li class="odd:bg-white even:bg-gray-100 px-6 py-4">
                                                <div class="flex justify-between">
                                                    <div class="flex items-center">
                                                        <div class="pr-2">#
                                                            <a href="{{ route('records', $archive) }}"> {{ $archive->name }}</a>
                                                        </div>
                                                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                        {{ $archive->total_records }}
                                                            {{ __('Records') }}
                                                    </span>
                                                    </div>
                                                    <div class="flex items-center gap-x-5">
                                                        <div x-data="{ tooltip: '{{ __('Click to read more')}}' }">
                                                            <a href="{{ $archive->link }}">
                                                                <svg  x-tooltip="tooltip"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                                </svg>
                                                            </a>


                                                        </div>
                                                        <a href="{{ route('records', $archive) }}">
                                                            {{ __('View archive') }} </a>
                                                    </div>

                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                @foreach( $catArchives as $category)

                                    <li>
                                        <p class="text-sm font-medium text-black-900 px-6 py-4">{{ $category->name }}</p>
                                        <ul class="rounded-lg bg-white overflow-hidden shadow">
                                            @foreach($category->archives as $archive)

                                                <li class="odd:bg-white even:bg-gray-100 px-6 py-2">
                                                    <div class="flex justify-between">
                                                        <div class="flex items-center">
                                                            <div class="pr-2 font-bold">
                                                               @if($archive->total_records > 0)
                                                                    <a href="{{ route('records', $archive) }}"> {{ $archive->name }}</a>
                                                                @else
                                                                    {{ $archive->name }}
                                                                @endif
                                                            </div>
                                                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                        {{ number_format($archive->total_records)}}
                                                        {{ __('Records') }}
                                                    </span>
                                                        </div>
                                                        <div class="flex items-center gap-x-5">
                                                            <div x-data="{ tooltip: '{{ __('Click to read more')}}' }">
                                                                <a href="{{ $archive->link }}">
                                                                    <svg  x-tooltip="tooltip"  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                                    </svg>
                                                                </a>


                                                            </div>
                                                            <a href="{{ route('records', $archive) }}">
                                                                {{ __('View archive') }} </a>
                                                        </div>

                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            @endif


                        </ul>

                    </div>
                </div>
            </section>


        </div>

        <!-- Right column -->

    </div>
</x-app-layout>
