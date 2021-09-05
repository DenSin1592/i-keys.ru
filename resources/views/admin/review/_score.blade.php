{!! Form::tbFormGroupOpen('score') !!}
{!! Form::tbLabel('score', trans("validation.attributes.review_score")) !!}

<div class="rating-box">
    <div class="rating" data-raty='{{ json_encode(
        [
            'score' => $formData['review']->score
        ]
    ) }}'>
    </div>
</div>

{!! Form::tbFormGroupClose() !!}


