<!--noindex-->
<?php echo e(Form::open(['url' => route('search.index'), 'class' => 'form-search', 'method' => 'get'])); ?>

    <?php echo e(Form::search('query', Request::get('query'), ['class' => 'search-input', 'placeholder' => 'Найдите свой продукт', 'autocomplete' => 'off'])); ?>

    <button type="submit" class="search-btn">
        <i class="icon-search"></i>
    </button>
<?php echo e(Form::close()); ?>

<!--/noindex--><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/_search_form.blade.php ENDPATH**/ ?>