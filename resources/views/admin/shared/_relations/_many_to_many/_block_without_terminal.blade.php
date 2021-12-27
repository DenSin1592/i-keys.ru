<fieldset class="bordered-group">
    <legend>{{$blockName}}</legend>

    <div class="field-hint-block">
        <p></p>
    </div>

    <div id="{{"modal-".$relationsName."-current"}}">
        @include('admin.shared._relations._many_to_many._current')
    </div>
</fieldset>
