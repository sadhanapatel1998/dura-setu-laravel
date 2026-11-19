@extends('layouts.site')
@section('content')
<?php $meta = dura_meta(['title' => 'Page Not Found | ' . setting('site_name'), 'robots' => 'noindex, nofollow']); ?>
<main>
    <section class="cs_section_padding text-center">
        <div class="container">
            <h1 class="cs_fs_64 cs_bold">404</h1>
            <p class="cs_fs_20">The page you are looking for does not exist.</p>
            <a href="{{ url('/') }}" class="cs_uni_card_btn d-inline-block">Back to Home</a>
        </div>
    </section>
</main>
@endsection
