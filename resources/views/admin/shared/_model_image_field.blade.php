{{-- Image field for model --}}

{!! Form::tbFormGroupOpen("{$field}_file") !!}
    {{ Form::label("{$field}_file", trans("validation.attributes.{$field}_file")) }}
    @if (!is_null($model->$field))
    <div class="loaded-image">
        <a href="{{{ $model->getAttachment($field)->getRelativePath() }}}" target="_blank" data-fancybox="">
            <img src="{{{ $model->getAttachment($field)->getRelativePath('thumb') }}}" />
        </a>
        <label>
            {!! Form::checkbox("{$field}_remove", 1) !!}
            удалить
        </label>
    </div>
    @endif
    <div class="file-upload-container">
        {!! Form::file("{$field}_file") !!}
        <label for="{{{ "{$field}_file_text" }}}">или url:</label>
        <input type="text" id="{{{ "{$field}_file_text" }}}" name="{{{ "{$field}_file" }}}" class="form-control" />
    </div>
{!! Form::tbFormGroupClose() !!}
