<div class="association {{ !empty($associationOpened) ? 'opened' : '' }}">
    {!! Form::tbFormGroupOpen("product_associations.{$associationType}.{$association->product_id}.name") !!}
        {!! Form::tbLabel("product_associations[{$associationType}][{$association->product_id}][name]", trans('validation.attributes.name')) !!}
        {!! Form::tbText("product_associations[{$associationType}][{$association->product_id}][name]", $association->name) !!}
    {!! Form::tbFormGroupClose() !!}
    {!! Form::tbFormGroupOpen("product_associations.{$associationType}.{$association->product_id}.position") !!}
        {!! Form::tbLabel("product_associations[{$associationType}][{$association->product_id}][position]", trans('validation.attributes.position')) !!}
        {!! Form::tbText("product_associations[{$associationType}][{$association->product_id}][position]", $association->position) !!}
    {!! Form::tbFormGroupClose() !!}
</div>
