@if (!is_null($formData['attribute']->id))
    <div class="form-group">
        <a href="{{ route('cc.attributes.allowed-values.index', $formData['attribute']->id) }}" class="btn btn-default" target="_blank">Редактировать разрешённые значения</a>
    </div>
@endif
