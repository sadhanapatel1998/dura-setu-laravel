<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <?php $meta = $meta ?? dura_meta(); ?>
    <title><?php echo e($meta['title']); ?></title>
    <meta name="description" content="<?php echo e($meta['description']); ?>">
    <meta name="keywords" content="<?php echo e($meta['keywords']); ?>">
    <meta name="robots" content="<?php echo e($meta['robots']); ?>">
    <link rel="canonical" href="<?php echo e($meta['canonical']); ?>">

    <meta property="og:site_name" content="<?php echo e(setting('site_name')); ?>">
    <meta property="og:type" content="<?php echo e($meta['og_type']); ?>">
    <meta property="og:title" content="<?php echo e($meta['title']); ?>">
    <meta property="og:description" content="<?php echo e($meta['description']); ?>">
    <meta property="og:url" content="<?php echo e($meta['canonical']); ?>">
    <meta property="og:image" content="<?php echo e($meta['og_image']); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($meta['title']); ?>">
    <meta name="twitter:description" content="<?php echo e($meta['description']); ?>">
    <meta name="twitter:image" content="<?php echo e($meta['og_image']); ?>">

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('assets/favicon/apple-touch-icon.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('assets/favicon/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('assets/favicon/favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('assets/favicon/site.webmanifest')); ?>">

    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/swiper.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/nice-select.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/odometer.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/remixicon.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/lightgallery.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/aos.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>?v=<?= file_exists(public_path('assets/css/style.css')) ? filemtime(public_path('assets/css/style.css')) : '1.0'; ?>">
    <link href="https://db.onlinewebfonts.com/c/bf7f60c66ad9f354c959a42e7e80b139?family=BreveNews-SemiBold" rel="stylesheet">
<?php foreach ($meta['schema'] as $schema): ?>
    <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?></script>
<?php endforeach; ?>
<?php if (setting('custom_css')): ?>
    <style><?php echo setting('custom_css'); ?></style>
<?php endif; ?>
    <?php echo setting('header_scripts'); ?>

</head>

<body>
    <?php echo setting('body_scripts'); ?>


    <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <button type="button" class="cs_scrollup_btn" aria-label="Scroll to top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <script defer src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('assets/js/swiper.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('assets/js/nice-select.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('assets/js/odometer.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('assets/js/lightgallery.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('assets/js/aos.min.js')); ?>"></script>
    <script defer src="<?php echo e(asset('assets/js/main.js')); ?>?v=<?= file_exists(public_path('assets/js/main.js')) ? filemtime(public_path('assets/js/main.js')) : '1.0'; ?>"></script>
<?php if ($meta['turnstile'] && setting('turnstile_site_key')): ?>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<?php endif; ?>
    <?php echo setting('footer_scripts'); ?>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\dashboard\dura-setu-laravel\resources\views/layouts/site.blade.php ENDPATH**/ ?>