<div>

        @if(Route::currentRouteName() === "records" )
            <a href="/home">{{ __('Hem') }}</a> / <a href="{{ route('records',$archive) }}">{{ $archive->name }}</a> / {{ __('search') }}
        @elseif(Route::currentRoutename() === "organizations.archives.records" )
                {{ __('Hem') }} / <a href="{{ route('organizations.archives.records',[$organization, $archive]) }}">{{ $archive->name }}</a> / {{ __('search') }}
        @elseif(Route::currentRoutename() === "records.show")
                <a href="/home">{{ __('Hem') }}</a>  / {{ $detail->archive->name }} / {{ $detail->first_name }} {{ $detail->last_name }}

        @else

        <a href="/home">{{ __('Hem') }}</a>   / {{ __('search') }} / {{ __('result') }}
    @endif
</div>
