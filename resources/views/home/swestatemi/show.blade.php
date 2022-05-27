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

                    @if($detail->from_province)
                        <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500"> {{ __('Province') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $detail->from_province }}
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
                        @if($detail->civil_status)
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500"> {{ __('Civil status') }}
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $detail->civil_status }}
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

                        @if($detail->birth_year)
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500"> {{ __('Birth year') }}
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $detail->birth_year }}.{{ $detail->birth_month }}.{{ $detail->birth_day }}
                                </dd>
                            </div>
                        @endif

                        @if($detail->destination)
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500"> {{ __('Destination') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $detail->destination }}
                                </dd>
                            </div>
                        @endif
                        @if($detail->comments)
                            <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500"> {{ __('Comments') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $detail->comments }}
                                </dd>
                            </div>
                        @endif

                </dl>
            </div>
        </div>

    </div>
</x-app-layout>
