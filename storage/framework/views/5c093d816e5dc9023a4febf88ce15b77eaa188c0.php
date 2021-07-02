<?php $__env->startSection('title'); ?>
    <?php echo e($product->category->name); ?> | <?php echo e($product->name); ?> - редактирование товара
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="form-group">
        <?php if($product->shop_id == '1' && !empty($product->shop_group_id) && !empty($product->shopGroup)): ?>
            <a target="_blank" class="btn btn-info"
               href="https://www.marketmatrasov.ru/cc/catalog_products/edit/<?php echo e($product->shopGroup->shop_group_key); ?>">
                Редактировать на marketmatrasov.ru
            </a>
        <?php elseif($product->shop_id == '2'): ?>
            <a target="_blank" class="btn btn-info"
               href="https://lstr-shop.ru/control-center/catalog-products/edit/<?php echo e($product->import_code); ?>">
                Редактировать на lstr-shop.ru
            </a>
        <?php elseif($product->shop_id == '3'): ?>
            <a target="_blank" class="btn btn-info"
               href="https://www.moya-postel.ru/control-center/catalog-products/<?php echo e($product->import_code); ?>/edit">
                Редактировать на moya-postel.ru
            </a>
        <?php endif; ?>
    </div>

    <?php echo Form::tbModelWithErrors($product, $errors, ['url' => route('cc.products.update', [$product->category->id, $product->id]), 'method' => 'put', 'files' => true, 'autocomplete' => 'off']); ?>


        <?php echo $__env->make('admin.products._form_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo Form::hidden('position', $product->position); ?>


        <div class="action-bar">
            <button type="submit" class="btn btn-success"><?php echo e(trans('interactions.save')); ?></button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index"><?php echo e(trans('interactions.save_and_back_to_list')); ?></button>
            <?php echo $__env->make('admin.products._delete_product', ['product' => $product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <a href="<?php echo e(route('cc.products.index', $product->category->id)); ?>" class="btn btn-default"><?php echo e(trans('interactions.back_to_list')); ?></a>
            <?php if($product->publish && $product->category->in_tree_publish): ?>
                <?php echo $__env->make('admin.shared._show_on_site_button', ['url' => CatalogUrlBuilder::buildProductUrl($product)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.products.inner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>