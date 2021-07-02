@extends('admin.layouts.default')

@section('title')
    Константы
@stop

@section('content')
    {!! Form::tbModelWithErrors([], $errors, ['url' => route('cc.settings.update'), 'method' => 'put', 'scrollable' => false]) !!}
    <table class="table settings-table">
        <thead>
        <tr>
            <th class="col-name">Название</th>
            <th class="col-value">Значение</th>
        </tr>
        </thead>
        @foreach ($formData['group_list'] as $group)
            <tbody>
            <tr>
                <th colspan="2">
                    <span class="toggle" data-group-id="{{ $group->getKey() }}">{{ $group->getName() }}</span>
                </th>
            </tr>
            </tbody>
            <tbody class="settings-group {!! Form::errorContains($group->getSettingKeys('setting.')) ? 'group-show' : '' !!}"
                   data-group-id="{{ $group->getKey() }}">
            @foreach ($group->getSettingValueList() as $setting)
                <tr>
                    <td class="col-name">
                        <label for="setting-{{ $setting->getPreparedKey() }}">{{ $setting->getName() }}:</label>
                        @if (!empty($setting->getDescription()))
                            <div class="setting-description">{!! $setting->getDescription() !!}</div>
                        @endif
                    </td>
                    <td class="col-value">
                        {!! Form::tbFormGroupOpen("setting.{$setting->getPreparedKey()}") !!}
                            @if ($setting->getType() === \App\Services\Settings\SettingValue::TYPE_TEXT)
                                {!! Form::tbText("setting[{$setting->getPreparedKey()}]", $setting->getValue(), ['id' => "setting-{$setting->getPreparedKey()}", 'class' => 'form-control input-sm']) !!}

                            @elseif ($setting->getType() === \App\Services\Settings\SettingValue::TYPE_TEXTAREA)
                                {!! Form::tbTextarea("setting[{$setting->getPreparedKey()}]", $setting->getValue(), ['id' => "setting-{$setting->getPreparedKey()}", 'class' => 'form-control input-sm', 'rows' => 6]) !!}

                            @elseif ($setting->getType() === \App\Services\Settings\SettingValue::TYPE_TEXTAREA_TINYMCE)
                                {!! Form::tbTextarea("setting[{$setting->getPreparedKey()}]", $setting->getValue(), ['id' => "setting-{$setting->getPreparedKey()}", 'class' => 'form-control input-sm', 'rows' => 6, 'data-tinymce' => true]) !!}

                            @elseif ($setting->getType() === \App\Services\Settings\SettingValue::TYPE_CHECKBOX)
                                <input type="hidden" name="setting[{{ $setting->getPreparedKey() }}]" value="0"/>
                                {!! Form::checkbox("setting[{$setting->getPreparedKey()}]", 1, $setting->getValue(), ['id' => "setting-{$setting->getPreparedKey()}", 'class' => 'checkbox']) !!}

                            @elseif ($setting->getType() === \App\Services\Settings\SettingValue::TYPE_REDIRECTS)
                                @include('admin.settings.form._redirects_field', ['rows' => old("setting.{$setting->getPreparedKey()}") ?: $setting->getValue()])

                            @else
                                {{ $setting->getValue() }}
                            @endif
                        {!! Form::tbFormGroupClose() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        @endforeach
        <tfoot>
        <tr>
            <td class="col-name">&nbsp;</td>
            <td class="col-value">
                <button type="submit" class="btn btn-success">Сохранить</button>
            </td>
        </tr>
        </tfoot>
    </table>
    {!! Form::close() !!}
@stop
