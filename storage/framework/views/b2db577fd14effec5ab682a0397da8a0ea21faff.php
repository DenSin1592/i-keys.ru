<?php if(isset($homePage)): ?>
    <section class="section-about">
        <div class="container">
            <div class="row flex-column-reverse flex-md-row">
                <div class="about-typography-container col-md-6 col-lg-5">
                    <h1><?php echo e($h1); ?></h1>
                    <?php if($homePage->sub_header != ''): ?>
                        <div class="about-subtitle"><?php echo e($homePage->sub_header); ?></div>
                    <?php endif; ?>
                    <?php if($homePage->content != ''): ?>
                        <div class="about-description"><?php echo $homePage->content; ?></div>
                    <?php endif; ?>
                </div>

                <?php if($homePage->getAttachment('image')->exists('content')): ?>
                    <div class="about-media-container col-md-6 offset-lg-1">
                        <figure class="about-thumbnail">
                            <img src="<?php echo e($homePage->getAttachment('image')->getUrl('content')); ?>" alt="<?php echo e(Str::ucfirst(Setting::get('general.site_name'))); ?>">
                        </figure>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/home_page/_info.blade.php ENDPATH**/ ?>