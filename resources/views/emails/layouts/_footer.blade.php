<div style="
border-top: 1px solid #CF3027;
color: gray; font-size: 13px; margin: 20px 15px; padding-top: 10px;">
    <div style="margin: 0 15px;">
        Для получения дополнительной информации Вы можете связаться с нами по адресу:
{{--        <a href="{{ Helper::mailtoLink(Setting::get('mail.for_display.address')) }}">{{ Setting::get('mail.for_display.address') }}</a>--}}
{{--        <br><br>--}}
{{--        @if(trim(Setting::get('common.phone')) !== '')--}}
{{--            Телефон: <a href="{{ Helper::telLink(Setting::get('common.phone')) }}">{{ Setting::get('common.phone') }}</a>--}}
{{--            <br>--}}
{{--        @endif--}}
        <a href="{{ route('home') }}">{!! Request::getHost() !!}</a>
    </div>
</div>
