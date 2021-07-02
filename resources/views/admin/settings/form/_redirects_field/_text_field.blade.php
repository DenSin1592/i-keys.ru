<input type="text"
       class="form-control"
       name="setting[{!! $setting->getKey() !!}][{!! $index !!}][{!! $field !!}]"
       value="{!! $value !!}"
       @if (!empty($disabled)) disabled="disabled" @endif
/>

@if(isset($setting, $index))
    {!! Form::tbFormFieldError("setting.{$setting->getKey()}.{$index}.{$field}") !!}
@endif
