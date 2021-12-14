{{-- Form fields for product --}}

{!! Form::tbFormGroupOpen('category_id') !!}
    {!! Form::tbLabel('category_id', trans('validation.attributes.category_id')) !!}
    {!! Form::tbSelect2('category_id', $formData['categoryVariants']) !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbFormGroupOpen('name') !!}
    {!! Form::tbLabel('name', trans('validation.attributes.name')) !!}
    {!! Form::tbText('name') !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbFormGroupOpen('alias') !!}
{!! Form::tbLabel('alias', trans('validation.attributes.alias')) !!}
{!! Form::tbText('alias') !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbFormGroupOpen('code_1c') !!}
    {!! Form::tbLabel('code_1c', trans('validation.attributes.code_1c')) !!}
    {!! Form::tbText('code_1c') !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbCheckboxBlock('publish') !!}
{!! Form::tbCheckboxBlock('best_prod') !!}

{!! Form::tbSelectBlock('existence', \App\Models\Product\ExistenceConstants::getExistenceVariants()) !!}

{!! Form::tbFormGroupOpen('price') !!}
    {!! Form::tbLabel('price', trans('validation.attributes.price')) !!}
    {!! Form::tbText('price') !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbFormGroupOpen('old_price') !!}
{!! Form::tbLabel('old_price', trans('validation.attributes.old_price')) !!}
{!! Form::tbText('old_price') !!}
{!! Form::tbFormGroupClose() !!}

@include('admin.products.form.images._images')

{!! Form::tbFormGroupOpen('description') !!}
    {!! Form::tbLabel('description', trans('validation.attributes.description')) !!}
    {!! Form::tbTinymceTextarea('description') !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbFormGroupOpen('extra_description') !!}
{!! Form::tbLabel('extra_description', trans('validation.attributes.extra_description')) !!}
{!! Form::tbTinymceTextarea('extra_description') !!}
{!! Form::tbFormGroupClose() !!}


<fieldset class="bordered-group">
    <legend>Характеристики</legend>
    <p>
        <i>
            Список возможных характеристик возможно изменить,
            перейдя по <a href="{{ route('cc.attributes.index') }}" target="_blank">ссылке</a>
        </i>
    </p>
    <div id="product-attributes" data-url="{{ route('cc.products.attributes.show', [$product->category->id, $product->id]) }}">
        @include('admin.products.form.attributes._attributes')
    </div>
</fieldset>

@include('admin.products.form._related_products', $formData)

@include('admin.shared._header_meta_field')
@include('admin.shared._form_meta_fields')

@include('admin.shared._model_timestamps', ['model' => $product])
