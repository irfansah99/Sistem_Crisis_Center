@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT2WV6eewfJaJ005vYBZep9IOzs8WjhQ4DwYw&s" alt="Crisis Center Logo">

@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
