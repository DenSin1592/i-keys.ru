{{-- Form fields for product --}}

{!! Form::hidden('category_id') !!}

{!! Form::tbFormGroupOpen('name') !!}
    {!! Form::tbLabel('name', trans('validation.attributes.name')) !!}
    {!! Form::tbText('name') !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbFormGroupOpen('alias') !!}
    {!! Form::tbLabel('alias', trans('validation.attributes.alias')) !!}
    {!! Form::tbText('alias') !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbCheckboxBlock('publish') !!}

{!! Form::tbFormGroupOpen('price') !!}
    {!! Form::tbLabel('price', trans('validation.attributes.price')) !!}
    {!! Form::tbText('price', null, ['disabled' => true]) !!}
{!! Form::tbFormGroupClose() !!}

@include('admin.products.form.images._images')

<fieldset class="bordered-group">
    <legend>Характеристики</legend>
    <p>
        <i>
            Список возможных характеристик возможно изменить,
            перейдя по <a href="{{ route('cc.attributes.index', $product->category->id) }}" target="_blank">ссылке</a>
        </i>
    </p>
    <div>
        @include('admin.products.form.attributes._attributes', ['disabled' => true])
    </div>
</fieldset>

@include('admin.shared._header_meta_field')

{!! Form::tbFormGroupOpen('extra_description') !!}
    {!! Form::tbLabel('extra_description', trans('validation.attributes.extra_description')) !!}
    {!! Form::tbTextarea('extra_description') !!}
{!! Form::tbFormGroupClose() !!}

@include('admin.shared._form_meta_fields')

@include('admin.shared._model_timestamps', ['model' => $product])
