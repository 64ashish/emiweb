
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


