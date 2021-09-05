{!!  Form::tbFormGroupOpen('review_date') !!}

{!! Form::tbLabel('review_date', trans('validation.attributes.review_date')) !!}

{!! Form::tbText(
'review_date',
!empty($formData['review']->review_date) ? date( "d.m.Y H:i:s" , strtotime($formData['review']->review_date)) : '',
['data-datetimepicker' => json_encode(['format' => "d.m.Y H:i:s"])]
) !!}

{!! Form::tbFormGroupClose() !!}

