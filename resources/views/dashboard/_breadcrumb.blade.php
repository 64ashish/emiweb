<div class="flex justify-between">
        <div>
                @switch(Route::currentRouteName())
                        @case( Route::currentRouteName() === "records")
                        <a href="/home">{{ __('Hem') }}</a> / <a href="{{ route('records',$archive) }}">{{ __($archive->name) }}</a> / {{ __('Search') }}
                        @break

                        @case( Route::currentRoutename() === "organizations.archives.records" )
                        {{ __('Hem') }} / <a href="{{ route('organizations.archives.records',[$organization, $archive]) }}">{{ __($archive->name) }}</a> / {{ __('Search') }}
                        @break

                        @case( Route::currentRoutename() === "records.show")
                        <a href="/home">{{ __('Hem') }}</a>  /<a href="{{ route('records',$archive_details) }}"> {{ __($archive_details->name) }}</a>/ {{ $detail->first_name }} {{ $detail->last_name }}
                        @break
                        @case( Str::is('*search', Route::currentRoutename()) == true)
                        <a href="/home">{{ __('Hem') }}</a>   / {{  __($archive_name->name) }}   / {{ __('result') }}
                        @break
                        @default

                @endswitch
        </div>
        @if(Route::currentRoutename() === "records.show")
        <div class="flex gap-x-5">
            <div x-data="{ openMessage: false }">
                <div class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-3 py-2 text-sm
                   font-medium leading-4 text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2
                   focus:ring-indigo-500 focus:ring-offset-2 cursor-pointer"
                     @click="openMessage = true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>

                    Frågor/tillägg
                </div>

                <div x-show="openMessage"  x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-20 overflow-y-auto p-4 sm:p-6 md:p-20" role="dialog"
                     aria-modal="true" style="display:none">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity"
                         aria-hidden="true"></div>
                    <div x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 scale-95"
                         x-transition:enter-end="opacity-100 scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 scale-100"
                         x-transition:leave-end="opacity-0 opacity-100 scale-100"
                         class="mx-auto max-w-xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
                        <div>
                            <div class="relative" @click.away="openMessage = false">
                                <div class="p-5">
                                    <div class="text-right cursor-pointer flex flex-row-reverse	" @click="openMessage = false">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>

                                    </div>
                                    <p>
                                        Message
                                    </p>
                                    {!! Form::open(['route' => 'suggestion']) !!}

                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start  sm:border-gray-200 sm:py-5">
                                        <label for="subject"
                                               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            Subject
                                        </label>
                                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                                            {!! Form::text('subject', null,
                                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                    'id' => 'Subject']) !!}
                                            @error('subject')
                                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                            </p>@enderror
                                        </div>
                                    </div>

                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
                                        <label for="email"
                                               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            Email </label>
                                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                                            {!! Form::text('email', null,
                                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                    'id' => 'email']) !!}
                                            @error('email')
                                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                            </p>@enderror
                                        </div>
                                    </div>

                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
                                        <label for="message"
                                               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            Message</label>
                                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                                            {!! Form::textarea('message', null,
                                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                    'id' => 'message']) !!}
                                            @error('message')
                                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                            </p>@enderror
                                        </div>
                                    </div>

                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
                                        <label for="archive"
                                               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            Archive </label>
                                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                                            {!! Form::text('archive',$archive_details->name ,
                                                    ['class' => 'max-w-lg block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                    'id' => 'archive', 'readonly']) !!}
                                            @error('archive')
                                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                            </p>@enderror
                                        </div>
                                    </div>

                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
                                        <label for="record"
                                               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            Record id</label>
                                        <div class="mt-1 sm:mt-0 sm:col-span-2">

                                            {!! Form::text('record', $archive_details->id,
                                                    ['class' => 'max-w-lg disabled block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                    'id' => 'record', 'readonly']) !!}
                                            @error('record')
                                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                            </p>@enderror
                                        </div>
                                    </div>

                                    <div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5">
                                        <label for="record"
                                               class="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2">
                                            Record URL</label>
                                        <div class="mt-1 sm:mt-0 sm:col-span-2">

{{--                                            {!! Form::hidden('record_url',url()->current(),['readonly']) !!}--}}

                                            {!! Form::text('record_url',url()->current(),
                                                    ['class' => 'max-w-lg disabled block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500
                                                    sm:max-w-xs sm:text-sm border-gray-300 rounded-md',
                                                    'id' => 'record', 'readonly']) !!}
                                            @error('record')
                                            <p class="mt-2 text-sm text-red-600" id="email-error">{{ $message }}
                                            </p>@enderror
                                        </div>
                                    </div>

                                    <div class="sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:py-5 flex justify-end">
                                        {!! Form::hidden('record_url',url()->current(),['readonly']) !!}
                                        <button type="submit"  class=" inline-flex items-center px-8 py-2 border
                                                       border-transparent text-base font-medium rounded-md shadow-sm text-white
                                                       {{ auth()->user()->hasRole('organization admin|organization staff') ? "bg-sky-800" : " bg-indigo-600 " }} hover:bg-indigo-700 focus:outline-none focus:ring-2
                                                       focus:ring-offset-2 focus:ring-indigo-500">{{ __('Send') }}
                                        </button>
                                    </div>

                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <a href="{{ route('records',$archive_details) }}"
               class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-3 py-2 text-sm
               font-medium leading-4 text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2
               focus:ring-indigo-500 focus:ring-offset-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>

                    {{ __('New search') }}
            </a>

        </div>
        @endif
</div>



