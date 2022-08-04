<div>
    @if(Route::currentRouteName() === "records" or Route::currentRoutename() === "organizations.archives.records")
        {{ __('Hem') }} / {{ $archive_name }} / {{ __('search') }}
    @else
        {{ __('Hem') }} / {{ $archive_name }} / {{ __('result') }}
    @endif
</div>
