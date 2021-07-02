<?php if($paginator->hasMorePages()): ?>
    <div class="row catalog-show-else">
        <div class="col">
            <a href="<?php echo e($paginator->nextPageUrl()); ?>"
               class="btn btn-section-link btn-highlight btn-block"><span>Показать еще <?php echo e($paginator->perPage()); ?></span></a>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/paginator/_show_more.blade.php ENDPATH**/ ?>