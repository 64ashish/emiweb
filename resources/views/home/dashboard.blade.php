<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <div class="grid grid-cols-1 gap-4 lg:col-span-2">
            <section aria-labelledby="section-1-title">

                <div class="rounded-lg overflow-hidden ">
                    <div class="p-6">
                        <ul role="list" class=" grid grid-cols-3 gap-8">
                            @foreach($archives as $archive)
                                <li class="bg-white p-8 rounded-lg flex flex-col ">
                                    <div class="text-sm	text-gray-400 leading-4">KATEGORI</div>
                                    <div class="font-bold text-xl	">{{ $archive->category->name }}</div>
                                    <div class="text-lg pb-3">{{ $archive->name }}</div>
                                    @if($archive->place)
                                        <div class="flex flex-wrap text-lg items-center ">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <span>{{ $archive->place }}</span>
                                        </div>
                                    @endif
                                    <div class="flex justify-between mt-auto pt-6 items-center">
                                        <div class="rounded-md bg-gray-100 px-7 py-3.5	text-sm font-normal">499 records</div>
                                        <a class="text-indigo-700">
                                           <a href="{{ route('records', $archive) }}"> Visa arkiv</a>
                                        </a>
                                    </div>
                                </li>
                            @endforeach

                        </ul>

                    </div>
                </div>
            </section>

        </div>

        <!-- Right column -->

    </div>
</x-app-layout>
