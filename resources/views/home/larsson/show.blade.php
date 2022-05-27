<x-app-layout>
    <!-- Main 3 column grid -->
    <div class="grid grid-cols-1 gap-4 items-start lg:gap-8">
        <!-- Left column -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">{{ __('Archive name') }}</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $detail->archive->name }}</p>
            </div>

            <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
                <dl  class="sm:divide-y sm:divide-gray-200 grid grid-cols-1 sm:grid-cols-2">
                    @if($detail->first_name)
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500"> {{ __('Full name') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $detail->first_name }} {{ $detail->last_name }}
                            </dd>
                        </div>
                    @endif

                    @if($detail->gender)
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500"> {{ __('Gender') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $detail->gender }}
                            </dd>
                        </div>
                    @endif

                    @if($detail->home_location)
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500"> {{ __('Home location') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $detail->home_location }}
                            </dd>
                        </div>
                    @endif

                        @if($detail->home_county)
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500"> {{ __('Home county') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $detail->home_county }}
                                </dd>
                            </div>
                        @endif

                        @if($detail->home_country)
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500"> {{ __('Country') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $detail->home_country }}
                                </dd>
                            </div>
                        @endif

                    @if($detail->home_province)
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500"> {{ __('Province') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $detail->home_province }}
                            </dd>
                        </div>
                    @endif
                    @if($detail->from_parish)
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500"> {{ __('Parish') }}
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $detail->from_parish }}
                            </dd>
                        </div>
                    @endif

                    @if($detail->from_year)
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500"> {{ __('From year') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $detail->from_year }}
                            </dd>
                        </div>
                    @endif


                    @if($detail->profession)
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500"> {{ __('Profession') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $detail->profession }}
                            </dd>
                        </div>
                    @endif



                    @if($detail->geographican_extent)
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500"> {{ __('Geographical extent') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $detail->geographican_extent }}
                            </dd>
                        </div>
                    @endif
                    @if($detail->language)
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500"> {{ __('Language') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $detail->language }}
                            </dd>
                        </div>
                    @endif

                        @if($detail->archive_reference)
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500"> {{ __('Archive reference') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $detail->archive_reference }}
                                </dd>
                            </div>
                        @endif
                        @if($detail->source_code)
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500"> {{ __('Source code') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $detail->source_code }}
                                </dd>
                            </div>
                        @endif
                        @if($detail->format)
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500"> {{ __('Format') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $detail->format }}
                                </dd>
                            </div>
                        @endif

                </dl>
            </div>
        </div>

    </div>
</x-app-layout>
