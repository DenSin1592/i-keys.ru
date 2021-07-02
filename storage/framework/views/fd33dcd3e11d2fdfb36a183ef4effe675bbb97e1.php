<div class="col-auto mx-auto mx-md-0 ml-md-auto mx-xl-auto d-flex align-items-center">
    <div class="header-contact-box d-flex align-items-center">
        <div class="header-clock">
            <i class="icon-clock-o d-none d-md-inline-block" ></i>
            Круглосуточно
        </div>

        <?php if(trim(\Setting::get('mail.feedback.address')) != ''): ?>
            <a href="mailto:<?php echo e(\Setting::get('mail.feedback.address')); ?>" class="header-contact">
                <i class="icon-envelope-o d-none d-md-inline-block"></i>
                <?php echo e(\Setting::get('mail.feedback.address')); ?>

            </a>
        <?php endif; ?>
    </div>

    <!-- todo: remove if-condition when user block will be returned -->
    <div class="header-contact-box d-flex align-items-center">
        <a href="tel:<?php echo e($sitePhone['short']); ?>" class="header-contact" >
            <i class="icon-phone d-none d-md-inline-block" ></i>
            <?php echo e($sitePhone['full']); ?>

        </a>

        <a href="javascript:void(0);"
           class="header-contact-action btn-outline btn-sm d-none d-md-inline-block"
           data-toggle="modal"
           data-target="#modalCallback"
        >
            Перезвоните мне
        </a>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/header/header_top/_phone.blade.php ENDPATH**/ ?>