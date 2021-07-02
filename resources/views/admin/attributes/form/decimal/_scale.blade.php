{!! Form::tbFormGroupOpen("decimal_scale") !!}
    {!! Form::tbLabel("decimal_scale", trans('validation.attributes.decimal_scale')) !!}
    {!! Form::tbText("decimal_scale", $formData['decimalScale']) !!}
    <div class="field-hint-block">
        От 0 до 3 включительно.
        При выводе на сайте все лишние знаки после запятой будут отброшены.
        В системе администрирования по прежнему можно будет задать все 3 знака после запятой.
    </div>
{!! Form::tbFormGroupClose() !!}
