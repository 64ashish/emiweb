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
                                                        {{ __('View Archive') }} </a>
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
                                                            {{ __('View Archive') }} </a>
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
