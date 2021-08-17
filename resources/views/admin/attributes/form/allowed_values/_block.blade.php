<fieldset class="bordered-group">
    <legend>{!! trans('validation.attributes.allowed_values') !!}</legend>

    <ul class="grouped-field-list" data-element-list="container" id="attribute-allowed-values">
        @foreach ($formData['allowedValues'] as $allowedValueKey => $allowedValue)
            @include('admin.attributes.form.allowed_values._element')
        @endforeach
    </ul>

    <span class="btn btn-default btn-xs grouped-field-list-add"
          data-element-list="add"
          data-element-list-target="#attribute-allowed-values"
          data-load-element-url="{{ route('cc.attributes.allowed-values.create') }}">Добавить разрешённое значение</span>
</fieldset>
