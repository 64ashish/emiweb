<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <div class="flex justify-between">
            <div>
                <a href="/home" class="text-indigo-600">{{ __('Home') }}</a> / <a href="/news" class="text-indigo-600">{{ __('News') }}</a> / {{ $latestNew->title }}
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
                </div>

            </div>
        </section>
    </div>
</x-app-layout>