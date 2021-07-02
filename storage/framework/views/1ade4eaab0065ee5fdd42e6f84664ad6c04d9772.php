

<?php echo Form::hidden('category_id'); ?>


<?php echo Form::tbFormGroupOpen('name'); ?>

    <?php echo Form::tbLabel('name', trans('validation.attributes.name')); ?>

    <?php echo Form::tbText('name', null, ['disabled' => true]); ?>

    <?php echo Form::hidden('name'); ?>

<?php echo Form::tbFormGroupClose(); ?>


<?php echo Form::tbFormGroupOpen('article'); ?>

    <?php echo Form::tbLabel('article', trans('validation.attributes.article')); ?>

    <?php echo Form::tbText('article', null, ['disabled' => true]); ?>

<?php echo Form::tbFormGroupClose(); ?>



<?php echo Form::tbFormGroupOpen('new_article'); ?>

    <?php echo Form::tbLabel('new_article', trans('validation.attributes.new_article')); ?>

<div class="field-hint-block">Новый артикул собирается из сопоставления старого артикула ('cc' => 'sd', 'T'  => 'EK' , 'Р' => 'F', 'C' => 'V', 'Н' => 'N', 'К' => 'M', 'Т' => 'D', 'КТ' => 'CS', 'В' => 'R') и id товара.</div>
<?php echo Form::tbText('new_article', null, ['disabled' => true]); ?>

<?php echo Form::tbFormGroupClose(); ?>


<?php echo Form::tbFormGroupOpen('alias'); ?>

    <?php echo Form::tbLabel('alias', trans('validation.attributes.alias')); ?>

    <?php echo Form::tbText('alias'); ?>

<?php echo Form::tbFormGroupClose(); ?>


<?php echo Form::tbCheckboxBlock('publish'); ?>


<?php echo Form::tbFormGroupOpen('price'); ?>

    <?php echo Form::tbLabel('price', trans('validation.attributes.price')); ?>

    <?php echo Form::tbText('price', null, ['disabled' => true]); ?>

<?php echo Form::tbFormGroupClose(); ?>


<?php echo Form::tbFormGroupOpen('old_price'); ?>

    <?php echo Form::tbLabel('old_price', trans('validation.attributes.old_price')); ?>

    <?php echo Form::tbText('old_price', null, ['disabled' => true]); ?>

<?php echo Form::tbFormGroupClose(); ?>


<?php echo Form::tbCheckboxBlock('bestseller'); ?>


<?php echo $__env->make('admin.products.form.images._images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('admin.products.form.video_reviews._video_reviews', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo Form::tbFormGroupOpen('manufacturer_id'); ?>

    <?php echo Form::tbLabel('manufacturer_id', trans('validation.attributes.manufacturer_id')); ?>

    <p>
        <i>
            Список возможных производителей возможно изменить,
            перейдя по <a href="<?php echo e(route('cc.manufacturers.index')); ?>" target="_blank">ссылке</a>
        </i>
    </p>
    <?php echo Form::tbSelect2('manufacturer_id', $formData['manufacturerVariants'], null, ['disabled' => true]); ?>

<?php echo Form::tbFormGroupClose(); ?>


<fieldset class="bordered-group">
    <legend>Характеристики</legend>
    <p>
        <i>
            Список возможных характеристик возможно изменить,
            перейдя по <a href="<?php echo e(route('cc.attributes.index', $product->category->id)); ?>" target="_blank">ссылке</a>
        </i>
    </p>
    <div>
        <?php echo $__env->make('admin.products.form.attributes._attributes', ['disabled' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</fieldset>

<?php echo $__env->make('admin.shared._header_meta_field', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo Form::tbTextareaBlock('content', null, null, ['disabled' => true]); ?>

<?php echo Form::tbTextareaBlock('import_description', null, null, ['disabled' => true, 'hint' => 'Не выводится на сайте']); ?>

<?php echo Form::tbTextareaBlock('admin_description', null, null, ['hint' => 'Не выводится на сайте']); ?>


<?php echo $__env->make('admin.shared._form_meta_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('admin.shared._model_timestamps', ['model' => $product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/_form_fields.blade.php ENDPATH**/ ?>