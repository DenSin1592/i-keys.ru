{{-- Image field for model --}}
{!! Form::tbFormGroupOpen("{$field}") !!}
{{ Form::label("{$field}", trans("validation.model_attributes.order.{$field}")) }}
@if (!is_null($model->$field))
    <div class="loaded-image">
        <a href="{{route('home') .'/uploads/document_legal_entity/'. $model->document}}">
            {{ $model->document }}
        </a>
        <label>
            {!! Form::checkbox("{$field}_remove", 1) !!}
            удалить
        </label>
    </div>
@endif
<div class="file-upload-container">
    {!! Form::file("{$field}") !!}
</div>
{!! Form::tbFormGroupClose() !!}
