@extends('layouts.site')
@section('content')
<main>
    <section class="cs_page_header cs_bg_filed" data-src="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
        <div class="container">
            <div class="cs_page_header_text">
                <h1 class="cs_page_header_title cs_fs_48 cs_bold"><?= htmlspecialchars($title); ?></h1>
                <ul class="cs_breadcrumb cs_mp_0 cs_fs_16">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><?= htmlspecialchars($title); ?></li>
                </ul>
            </div>
        </div>
    </section>
    <section class="cs_section_padding">
        <div class="container">
            <div class="cs_blog_content"><?= dura_fix_html($body); ?></div>
        </div>
    </section>
</main>
<style>.cs_blog_content{font-size:17px;line-height:1.8}.cs_blog_content h2,.cs_blog_content h3{margin:1.6rem 0 .8rem}.cs_blog_content img{max-width:100%;height:auto}.cs_blog_content ul,.cs_blog_content ol{padding-left:1.4rem}</style>
@endsection