@props(['label', 'value' => null])
@if(!is_null($value) && $value !== '')
<tr>
    <td style="padding:9px 0; border-bottom:1px solid #f1f5f9; font-size:13px; color:#64748b; width:150px; vertical-align:top;">{{ $label }}</td>
    <td style="padding:9px 0; border-bottom:1px solid #f1f5f9; font-size:14px; color:#0f172a; vertical-align:top;">{{ $slot->isNotEmpty() ? $slot : $value }}</td>
</tr>
@endif
