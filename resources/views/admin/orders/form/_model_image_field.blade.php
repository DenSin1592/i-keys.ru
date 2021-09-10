{{-- Image field for model --}}
{!! Form::tbFormGroupOpen("{$field}_file") !!}
{{ Form::label("{$field}_file", trans("validation.model_attributes.order.{$field}_file")) }}
@if (!is_null($model->$field))
    <div class="loaded-image">
        <a href="{{{ $model->getAttachment($field)->getRelativePath() }}}" target="_blank" data-fancybox="">
            <img src="{{{ $model->getAttachment($field)->getRelativePath('thumb') }}}"/>
        </a>
        <label>
            {!! Form::checkbox("{$field}_remove", 1) !!}
            удалить
        </label>
    </div>
@endif
<div class="file-upload-container">
    {!! Form::file("{$field}_file") !!}
</div>
{!! Form::tbFormGroupClose() !!}
