<fieldset class="bordered-group">
    <legend>Товары</legend>

    <?php echo Form::tbSelectBlock('sorting', $formData['productsData']['sortingVariants']); ?>


    <?php echo Form::tbCheckboxBlock('shuffle_products', 'Перемешать товары', null, ['hint' => 'Товары будут перемешаны один раз. Перемешивание работает только в случае, если выбрана сортировка "по популярности". ВНИМАНИЕ! Перемешивание выполняется не сразу, а в течении некоторого времени после сохранения страницы. Причина - огромное количество товаров и, следовательно, время перемешивания.']); ?>


    <div class="form-group">
        <?php if($formData['type']->exists): ?>
            <a class="btn btn-default" href="<?php echo e(route('cc.types.products.index', [$formData['type']->id])); ?>">Список товаров</a>
        <?php else: ?>
            <span>Список товаров будет доступен только после создания типа</span>
        <?php endif; ?>
    </div>
</fieldset>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/types/products/_products_block.blade.php ENDPATH**/ ?>