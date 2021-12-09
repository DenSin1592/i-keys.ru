<table style="border-collapse: collapse; margin: 1em 0;">
    <tbody>
        @foreach ($data as $name => $value)
            <tr>
                <td style="padding: 0.2em 1em 0.2em 1em; border-top: 1px dotted; vertical-align: top;">{!! $name !!}:</td>
                <td style="padding: 0.2em 1em 0.2em 0; border-top: 1px dotted; vertical-align: top;">{!! $value !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>