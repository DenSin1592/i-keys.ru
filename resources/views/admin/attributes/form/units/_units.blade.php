{!! Form::tbFormGroupOpen("units") !!}
    {!! Form::tbLabel("units", trans('validation.attributes.units')) !!}
    {!! Form::tbText("units", $formData['units']) !!}
    <div class="field-hint-block">
        Единицы измерений для значений параметров.
        Данный текст, если задан, он будет выводится после всех значений данного атрибута на сайте.
        Например, 20 см., где "см." - постфикс, "20" - значение.
    </div>
{!! Form::tbFormGroupClose() !!}
