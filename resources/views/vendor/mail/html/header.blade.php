@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ asset('images/logo.png') }}" width="200" alt="{{ config('app.name') }} Logo">
        </a>
    </td>
</tr>