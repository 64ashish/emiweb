<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <div class="grid grid-cols-1 gap-4 lg:col-span-2">
            <section aria-labelledby="section-1-title">

                <div class="rounded-lg bg-white overflow-hidden shadow">
                    <div class="p-6">
                        <h2>
                            Archives List
                        </h2>
                        <ul role="list" class="divide-y divide-gray-200">
                            @foreach( $groups as $group => $places)
                                <li class="py-4 flex flex-col">
                                    <p class="text-sm font-medium text-black-900">Category: {{ $group }}</p>
                                    @foreach($places as $place => $archives)
                                        <p class="text-sm font-medium text-gray-900 pl-3">Places: {{ $place }}</p>
                                        <ul class="pl-6">
                                            @foreach($archives as $archive)
                                                <li class="py-1">
                                                    <div class="flex items-center space-x-4">

                                                        <div class="flex-1 min-w-0">
                                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $archive->name }}</p>
                                                            <p class="text-sm text-gray-500 truncate">Total records: 499</p>
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('records', $archive) }}" class="inline-flex
                                                            items-center shadow-sm px-2.5 py-0.5 border
                                                            border-gray-300 text-sm leading-5 font-medium
                                                            rounded-full text-gray-700 bg-white hover:bg-gray-50"> View </a>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>

                                    @endforeach
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
