@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://db2.emiweb.se/images/Emiweb_logo.svg" class="logo" alt="Emiweb">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
