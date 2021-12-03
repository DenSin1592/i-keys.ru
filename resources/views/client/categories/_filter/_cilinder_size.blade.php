<div class="filter-group">
<div class="filter-group-header">
    <div class="filter-group-title title-h4">{!! $lensData['name']  !!}</div>
</div>

<div class="filter-group-content">
    <div class="filter-sheme-options-block">
        <div class="row flex-nowrap no-gutters">
            <div class="filter-sheme-option-column col-5">
                <div class="filter-sheme-option-group">
                    <label for="filter-sheme-option-1" class="filter-sheme-option-title" >Внеш.</label>

                    <select name="" id="filter-sheme-option-1" class="filter-sheme-option-select custom-control custom-select" style="width: 100%;" >
                        <option value="30мм">30мм</option>
                        <option value="40мм">40мм</option>
                    </select>
                </div>
            </div>

            <div class="filter-sheme-option-column col-7">
                <div class="filter-sheme-option-group">
                    <label for="filter-sheme-option-2" class="filter-sheme-option-title" >Внутр.</label>

                    <select name="" id="filter-sheme-option-2" class="filter-sheme-option-select custom-control custom-select" style="width: 100%;" >
                        <option value="75мм">75мм</option>
                        <option value="85мм">85мм</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-sheme-block">
        <div class="filter-sheme-thumbnail">
            <img loading="lazy" src="{{asset('/images/client/filter/filter-sheme-1.png')}}" width="323" height="130" alt="" class="filter-sheme-media">
        </div>
    </div>
</div>
</div>
