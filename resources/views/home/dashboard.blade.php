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
                                                        <div class="pr-2">{{ $archive->name }}</div>
                                                        <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                                        {{ $archive->total_records }}
                                                        Records
                                                    </span>
                                                    </div>
                                                    <a href="{{ route('records', $archive) }}">
                                                        {{ __('View archive') }} </a>
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
                                                            <div x-data="{ tooltip: '{{ $archive->name }}' }">
                                                                <svg x-tooltip="tooltip" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                                                                </svg>

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
