<div id="redirectsContainer">
    <div class="row" style="padding-top: 4px;">
        <div class="col-sm-4"><label>Правило</label></div>
        <div class="col-sm-1"></div>
        <div class="col-sm-4"><label>Ссылка</label></div>
        <div class="col-sm-1"></div>
    </div>

    <div>
        <div data-element-list="rules">
            @if (count($rows) > 0)
                <?php $index = 0; ?>
                @foreach($rows as $row)
                    @include('admin.settings.form._redirects_field._row', ['rule' => $row['rule'], 'url' => $row['url']])
                    <?php $index++; ?>
                @endforeach
            @else
                @include('admin.settings.form._redirects_field._row', ['index' => 0, 'rule' => null, 'url' => null])
            @endif
        </div>

        @include('admin.settings.form._redirects_field._template_row')
        <div class="row">
            <div class="col-sm-9"></div>
            <div class="col-sm-1">
                <button type="button" class="btn btn-default" data-rule-action="add"><i class="fa fa-plus"></i></button>
            </div>
        </div>
    </div>
</div>