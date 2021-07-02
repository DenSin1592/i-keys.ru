
<ul <?php if(empty($lvl)): ?> class="scrollable-container" <?php endif; ?>>
    <?php $__currentLoopData = $menu_lvl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu_element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(isset($menu_element['elements'])): ?>
            <li class="element-group-wrapper <?php if($menu_element['active']): ?> active <?php endif; ?>">
                <span class="menu-element">
                    <span class="decoration"><?php echo e($menu_element['name']); ?></span>
                    <span class="glyphicon <?php echo e($menu_element['icon']); ?>" title="<?php echo e($menu_element['name']); ?>" data-toggle="tooltip" data-placement="right"></span>
                </span>

                <div class="element-group">
                    <?php echo $__env->make('admin.layouts._main_menu_lvl', ['menu_lvl' => $menu_element['elements'], 'lvl' => isset($lvl) ? $lvl + 1 : 1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </li>
        <?php else: ?>
            <li>
                <a href="<?php echo e($menu_element['link']); ?>" class="menu-element <?php if($menu_element['active']): ?> active <?php endif; ?>">
                    <span class="text"><?php echo e($menu_element['name']); ?></span>
                    <span class="glyphicon <?php echo e($menu_element['icon']); ?>" title="<?php echo e($menu_element['name']); ?>" data-toggle="tooltip" data-placement="right"></span>
                </a>
            </li>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /home/kristinayudina/works/l-keys.ru_2021/www/resources/views/admin/layouts/_main_menu_lvl.blade.php ENDPATH**/ ?>