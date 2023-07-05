@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://emiwebdb.kortaben.work/images/emiweb-w.svg" class="logo" alt="Emiweb">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
