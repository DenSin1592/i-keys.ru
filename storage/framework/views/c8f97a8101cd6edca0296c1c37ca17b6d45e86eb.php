<fieldset class="bordered-group product-name-templates-block">
    <legend>Шаблоны названий товаров</legend>

    <div class="field-hint-block">
        <strong>Описание шаблонов</strong>
        <br />
        Названия генерируются по расписанию в 2:00 ежедневно. Названия для типов, заданные вручную, не заменяются сгенерированными при выводе.
        <br />
        Если задано несколько шаблонов, они будут использованы все поочереди.
        <br />
        Если задан пустой шаблон, сгенерированное название будет обнулено, когда шалон применится к товару.
        <br />
        Если не задано ни одного шаблона, все сгенерированные названия будут обнулены.
        <br />
        <br />

        <strong>Правила формирования названий по шаблонам.</strong>
        <br />
        <?php echo nl2br(e($formData['productNameTemplatesHint'])); ?>

    </div>

    <div class="template-list">
        <?php $__currentLoopData = $formData['productNameTemplates']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nameTemplate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('admin.types.product_name_templates._template', ['nameTemplate' => $nameTemplate, 'disabled' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div>
        <button class="btn btn-default btn-xs add-template" type="button">Добавить шаблон</button>
        <div class="template-example">
            <?php echo $__env->make('admin.types.product_name_templates._template', ['nameTemplate' => '', 'disabled' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
</fieldset>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/types/product_name_templates/_templates.blade.php ENDPATH**/ ?>