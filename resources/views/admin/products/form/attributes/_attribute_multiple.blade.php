<div>
    <div class="multi-checkbox">
        <div class="variants-container">
            @foreach (array_chunk($attribute['allowedValues'], 4, true) as $chunk)
                <div class="multi-checkbox-row">
                    @foreach ($chunk as $allowedId => $allowedName)
                        <div class="multi-checkbox-element">
                            <label class="checkbox-inline">
                                {!! Form::checkbox("attributes[{$attribute['attribute']->id}][]", $allowedId, in_array($allowedId, $attribute['data'])) !!}
                                {{ $allowedName }}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>