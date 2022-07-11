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
                                <li class="bg-white p-8 rounded-lg flex flex-col {{ $archive->Record_Total==0 ? "opacity-50" : "" }}">
                                    <div class="text-sm	text-gray-400 leading-4">{{ __('Category') }}</div>
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
                                        <div class="bg-gray-100 py-2 px-4 rounded">
                                            {{ $archive->Record_Total }} Records
                                        </div>
                                        <div class="text-indigo-700">
                                           @if($archive->Record_Total > 0)
                                            <a href="{{ route('records', $archive) }}" class="flex items-center">{{ __('View archive') }}
                                                <svg class="ml-1" width="13" height="16" viewBox="0 0 13 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M12.7071 8.70711C13.0976 8.31658 13.0976 7.68342 12.7071 7.29289L6.34315 0.928932C5.95262 0.538408 5.31946 0.538408 4.92893 0.928932C4.53841 1.31946 4.53841 1.95262 4.92893 2.34315L10.5858 8L4.92893 13.6569C4.53841 14.0474 4.53841 14.6805 4.92893 15.0711C5.31946 15.4616 5.95262 15.4616 6.34315 15.0711L12.7071 8.70711ZM0 9H12V7H0V9Z" fill="#4E46DC"/>
                                                </svg></a>
                                            @else
                                                <a>{{ __('View archive') }}</a>
                                            @endif
                                        </div>
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
