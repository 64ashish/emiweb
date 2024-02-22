<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <div class="flex justify-between">
            <div>
                <a href="/home" class="text-indigo-600">{{ __('Home') }}</a> / {{ __('News') }}
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <section class="pt-6" aria-labelledby="section-1-title">

            <div class="bg-white py-6 pl-4 pr-3 border-gray-300 shadow md:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('News') }}</h3>
                </div>

                <div class="border-t border-gray-200 px-4 py-5 sm:px-6">

                    <h1 class="text-left text-lg mt-4 font-bold text-gray-900 pb-4">{{ $latestNew->title }}</h1>
                    <div>
                        <div class="elementor-container elementor-column-gap-default">
                            {!! $latestNew->content !!}
                        </div>
                    </div>
                    <div class="pb-8"><span class=" mt-4 font-bold text-gray-900 text-sm">{{ __('Created at') }} :</span>{{ $latestNew->create_time }} <span class=" mt-4 font-bold text-gray-900 text-sm ml-2">{{ __('Update Time') }} : </span>
                        @if ($latestNew->update_time != '0000-00-00 00:00:00')
                        {{ $latestNew->update_time }}
                        @endif
                    </div>


                    <table class="min-w-full border-separate" style="border-spacing: 0">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="w-24 sticky top-16 z-10 border-b border-gray-300 bg-gray-50 bg-opacity-75 py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:pl-6 lg:pl-8">{{ __('Older news') }}</th>
                                <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:table-cell">{{ __('Created at') }}</th>
                                <th scope="col" class="sticky top-16  z-10 hidden border-b border-gray-300 bg-gray-50 bg-opacity-75 px-3 py-3.5 text-left text-sm font-semibold text-gray-900 backdrop-blur backdrop-filter sm:table-cell">{{ __('Update Time') }}</th>

                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach($latestNews as $new)
                            <tr class="group hover:bg-indigo-600">
                                <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500 group-hover:text-white hidden sm:table-cell">
                                    <a href="{{ route('new.show', ['id' => $new->id]) }}">{{ $new->title }}</a>
                                </td>
                                <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500  group-hover:text-white hidden sm:table-cell">{{ $new->create_time}}</td>
                                <td class="whitespace-nowrap border-b border-gray-200 px-3 py-4 text-sm text-gray-500  group-hover:text-white hidden sm:table-cell"> @if ($latestNew->update_time != '0000-00-00 00:00:00')
                                    {{ $latestNew->update_time }}
                                    @endif
                                </td>

                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <div class="pagination">
                        {{ $latestNews->links() }}
                    </div>
                </div>

            </div>
        </section>
    </div>
</x-app-layout>