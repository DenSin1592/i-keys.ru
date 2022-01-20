{{-- Image field for model --}}
{!! Form::tbFormGroupOpen("image") !!}
{{ Form::label("image", trans("validation.services.image")) }}
@if (!is_null($formData['service']->image))
    <div class="loaded-image" >
        <a href="{{{ route('home') .'/uploads/services/'. $formData['service']->image }}}" target="_blank" data-fancybox="">
            <img width="100" src="{{{ route('home') .'/uploads/services/'. $formData['service']->image }}}"/>
        </a>
        <label>
            {!! Form::checkbox("image_remove", 1) !!}
            удалить
        </label>
    </div>
@endif
{!! Form::tbFormGroupClose() !!}

{!! Form::tbFormGroupOpen("download_image") !!}
<div class="file-upload-container">
    {!! Form::file("image") !!}
</div>
{!! Form::tbFormGroupClose() !!}

