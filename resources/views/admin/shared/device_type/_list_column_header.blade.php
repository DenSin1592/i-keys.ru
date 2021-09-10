@if(\Auth::guard('admin')->user()->super)
    <div class="device_type">{!! trans('validation.attributes.device_type') !!}</div>
@endif