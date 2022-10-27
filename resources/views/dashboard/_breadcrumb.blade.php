<div class="flex justify-between">
        <div>
                @switch(Route::currentRouteName())
                        @case( Route::currentRouteName() === "records")
                        <a href="/home">{{ __('Hem') }}</a> / <a href="{{ route('records',$archive) }}">{{ $archive->name }}</a> / {{ __('Search') }}
                        @break

                        @case( Route::currentRoutename() === "organizations.archives.records" )
                        {{ __('Hem') }} / <a href="{{ route('organizations.archives.records',[$organization, $archive]) }}">{{ $archive->name }}</a> / {{ __('Search') }}
                        @break

                        @case( Route::currentRoutename() === "records.show")
                        <a href="/home">{{ __('Hem') }}</a>  /<a href="{{ route('records',$archive_details) }}"> {{ $archive_details->name }} </a>/ {{ $detail->first_name }} {{ $detail->last_name }}
                        @break
                        @case( Str::is('*search', Route::currentRoutename()) == true)
                        <a href="/home">{{ __('Hem') }}</a>   / {{  $archive_name->name }}  / {{ __('result') }}
                        @break
                        @default

                @endswitch
        </div>
        @if(Route::currentRoutename() === "records.show")
        <div>
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



