@if (isset($formData['allowedValues']))
    @include('admin.attributes.form.allowed_values._block')
@endif
@if (isset($formData['isDecimal']))
    @include('admin.attributes.form.decimal._scale')
@endif
@if (isset($formData['hasUnits']))
    @include('admin.attributes.form.units._units')
@endif