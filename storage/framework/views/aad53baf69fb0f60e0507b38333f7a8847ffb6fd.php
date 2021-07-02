<div class="range-lens">
    <div class="range-lens-col">
        <?php echo Form::text("filter[{$lensData['key']}][from]", $lensData['variants']->variants()['fromActual'], ['class' => 'form-control input-sm']); ?>

        <?php echo e($lensData['variants']->variants()['min']); ?>

    </div>
    <div class="range-lens-col">
        -
    </div>
    <div class="range-lens-col">
        <?php echo Form::text("filter[{$lensData['key']}][to]", $lensData['variants']->variants()['toActual'], ['class' => 'form-control input-sm']); ?>

        <?php echo e($lensData['variants']->variants()['max']); ?>

    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/types/filter/lens/_range.blade.php ENDPATH**/ ?>