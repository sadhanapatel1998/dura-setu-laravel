<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <?php $meta = $meta ?? dura_meta(); ?>
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}">
    <meta name="keywords" content="{{ $meta['keywords'] }}">
    <meta name="robots" content="{{ $meta['robots'] }}">
    <link rel="canonical" href="{{ $meta['canonical'] }}">

    <meta property="og:site_name" content="{{ setting('site_name') }}">
    <meta property="og:type" content="{{ $meta['og_type'] }}">
    <meta property="og:title" content="{{ $meta['title'] }}">
    <meta property="og:description" content="{{ $meta['description'] }}">
    <meta property="og:url" content="{{ $meta['canonical'] }}">
    <meta property="og:image" content="{{ $meta['og_image'] }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $meta['title'] }}">
    <meta name="twitter:description" content="{{ $meta['description'] }}">
    <meta name="twitter:image" content="{{ $meta['og_image'] }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/favicon/site.webmanifest') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/swiper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/odometer.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/remixicon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/lightgallery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v=<?= file_exists(public_path('assets/css/style.css')) ? filemtime(public_path('assets/css/style.css')) : '1.0'; ?>">
    <link href="https://db.onlinewebfonts.com/c/bf7f60c66ad9f354c959a42e7e80b139?family=BreveNews-SemiBold" rel="stylesheet">
<?php foreach ($meta['schema'] as $schema): ?>
    <script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG); ?></script>
<?php endforeach; ?>
<?php if (setting('custom_css')): ?>
    <style>{!! setting('custom_css') !!}</style>
<?php endif; ?>
    {!! setting('header_scripts') !!}
</head>

<body>
    {!! setting('body_scripts') !!}

    @include('partials.header')
    @yield('content')
    @include('partials.footer')

    <button type="button" class="cs_scrollup_btn" aria-label="Scroll to top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <script defer src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/swiper.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/nice-select.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/odometer.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/lightgallery.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/aos.min.js') }}"></script>
    <script defer src="{{ asset('assets/js/main.js') }}?v=<?= file_exists(public_path('assets/js/main.js')) ? filemtime(public_path('assets/js/main.js')) : '1.0'; ?>"></script>
<?php if ($meta['turnstile'] && setting('turnstile_site_key')): ?>
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<?php endif; ?>
    {!! setting('footer_scripts') !!}
</body>

</html>
