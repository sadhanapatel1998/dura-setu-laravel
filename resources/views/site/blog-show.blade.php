@extends('layouts.site')
@section('content')
<main>
    <!-- Page Header / Breadcrumb -->
    <section class="cs_page_header cs_bg_filed" data-src="{{ asset('assets/img/breadcrumb-bg.jpg') }}">
        <div class="container">
            <div class="cs_page_header_text">
                <h1 class="cs_page_header_title cs_fs_48 cs_bold mb-2"><?= htmlspecialchars($blog['title']); ?></h1>
                <ul class="cs_breadcrumb cs_mp_0 cs_fs_16">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('blogs') }}">Blogs</a></li>
                    <li class="active"><?= htmlspecialchars($blog['title']); ?></li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="cs_section_padding cs_blog_main_section">
        <div class="container">
            <div class="row cs_gap_y_40">
                <!-- Left: Main Article -->
                <div class="col-lg-8">
                    <article class="cs_blog_article_card">
                        <?php if ($blog['image']): ?>
                        <div class="cs_blog_featured_wrap">
                            <img src="<?= htmlspecialchars(dura_path($blog['image'])); ?>" alt="<?= htmlspecialchars($blog['title']); ?>" class="w-100 cs_radius_20 mb-4 cs_blog_featured_img">
                        </div>
                        <?php endif; ?>

                        <div class="cs_blog_meta_bar cs_fs_14 mb-4">
                            <?php if ($blog['category']): ?>
                                <span class="cs_blog_cat_badge"><?= htmlspecialchars($blog['category']); ?></span>
                            <?php endif; ?>
                            <span class="cs_blog_date">
                                <i class="ri-calendar-line"></i>
                                <time datetime="<?= date('Y-m-d', strtotime($blog['published_at'] ?: 'now')); ?>"><?= date('d M Y', strtotime($blog['published_at'] ?: 'now')); ?></time>
                            </span>
                            <?php if ($blog['author']): ?>
                                <span class="cs_blog_author">
                                    <i class="ri-user-3-line"></i> <?= htmlspecialchars($blog['author']); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="cs_blog_content">
                            @php
                            $blogHtml = dura_fix_html($blog['content']);
                            // Wrap bare tables in responsive scroll wrapper for clean mobile experience
                            $blogHtml = preg_replace_callback(
                                '#<table\b[^>]*>.*?</table>#is',
                                function($m) {
                                    return '<div class="cs_table_responsive">' . $m[0] . '</div>';
                                },
                                $blogHtml
                            );
                            @endphp
                            {!! $blogHtml !!}
                        </div>

                        <div class="mt-5">
                            <a href="{{ url('contact') }}" class="cs_primary_btn cs_radius_50 d-inline-flex align-items-center gap-2">
                                <span>Get Free Counselling</span>
                                <i class="ri-arrow-right-line"></i>
                            </a>
                        </div>
                    </article>
                </div>

                <!-- Right: Recent Articles Sidebar -->
                <aside class="col-lg-4">
                    <div class="cs_blog_sidebar">
                        <h2 class="cs_fs_22 cs_semibold mb-4 cs_sidebar_heading">Recent Articles</h2>
                        <?php if (!empty($recent)): ?>
                            <div class="cs_recent_articles_list">
                                <?php foreach ($recent as $rb): ?>
                                <a href="<?= htmlspecialchars($rb['url']); ?>" class="cs_recent_article_item">
                                    <img src="<?= htmlspecialchars($rb['image']); ?>" alt="<?= htmlspecialchars($rb['title']); ?>" loading="lazy" class="cs_recent_article_thumb">
                                    <div class="cs_recent_article_body">
                                        <span class="cs_recent_article_title"><?= htmlspecialchars($rb['title']); ?></span>
                                        <?php if (!empty($rb['published_at'])): ?>
                                        <span class="cs_recent_article_date">
                                            <i class="ri-calendar-line"></i> <?= date('d M Y', strtotime($rb['published_at'])); ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</main>

<style>
/* Page Layout */
.cs_blog_main_section {
    background-color: #f8fafc;
}

/* Main Article Card */
.cs_blog_article_card {
    background: #ffffff;
    border-radius: 20px;
    padding: 36px 40px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 20px rgba(2, 35, 79, 0.04);
}

.cs_blog_featured_img {
    max-height: 440px;
    object-fit: cover;
    border-radius: 16px;
    display: block;
}

/* Meta Bar */
.cs_blog_meta_bar {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    padding-bottom: 16px;
    border-bottom: 1px solid #f1f5f9;
    color: #64748b;
}

.cs_blog_cat_badge {
    background: #fef3c7;
    color: #b45309;
    font-size: 13px;
    font-weight: 700;
    padding: 3px 12px;
    border-radius: 50px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.cs_blog_date, .cs_blog_author {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* Content Typography */
.cs_blog_content {
    font-size: 17.5px;
    line-height: 1.85;
    color: #334155;
    word-break: break-word;
    overflow-wrap: break-word;
}

.cs_blog_content p {
    margin-bottom: 20px;
}

.cs_blog_content h2 {
    font-size: 26px;
    font-weight: 700;
    color: #02234f;
    margin-top: 36px;
    margin-bottom: 16px;
    padding-left: 12px;
    border-left: 4px solid #fc9502;
    line-height: 1.35;
}

.cs_blog_content h3 {
    font-size: 21px;
    font-weight: 600;
    color: #002671;
    margin-top: 28px;
    margin-bottom: 12px;
    line-height: 1.4;
}

.cs_blog_content h4 {
    font-size: 18px;
    font-weight: 600;
    color: #02234f;
    margin-top: 22px;
    margin-bottom: 10px;
}

.cs_blog_content blockquote {
    background: #f8fafc;
    border-left: 4px solid #002671;
    padding: 18px 24px;
    border-radius: 0 12px 12px 0;
    margin: 26px 0;
    font-style: italic;
    color: #1e293b;
    font-size: 17px;
}

.cs_blog_content ul, .cs_blog_content ol {
    margin: 18px 0;
    padding-left: 24px;
}

.cs_blog_content li {
    margin-bottom: 8px;
    line-height: 1.7;
}

.cs_blog_content img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    margin: 24px auto;
    display: block;
}

.cs_blog_content a {
    color: #002671;
    font-weight: 600;
    text-decoration: underline;
    text-underline-offset: 3px;
    transition: color 0.2s;
}

.cs_blog_content a:hover {
    color: #fc9502;
}

/* Table Styles & Responsive Scrolling */
.cs_table_responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin: 24px 0;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    background: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
}

.cs_table_responsive::-webkit-scrollbar {
    height: 6px;
}
.cs_table_responsive::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}
.cs_table_responsive::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.cs_blog_content table,
.cs_table_responsive table {
    width: 100%;
    border-collapse: separate !important;
    border-spacing: 0 !important;
    margin: 0 !important;
    border: none !important;
}

.cs_table_responsive colgroup col {
    width: auto !important;
}

.cs_table_responsive th,
.cs_table_responsive td {
    padding: 12px 16px !important;
    font-size: 14.5px !important;
    color: #475569 !important;
    border-top: 1px solid #edf2f7 !important;
    border-right: 1px solid #edf2f7 !important;
    vertical-align: top;
    min-width: 120px;
}

.cs_table_responsive th:last-child,
.cs_table_responsive td:last-child {
    border-right: none !important;
}

.cs_table_responsive td p,
.cs_table_responsive th p {
    margin-bottom: 0 !important;
    line-height: 1.5 !important;
    font-size: inherit !important;
    color: inherit !important;
}

/* First Row Header */
.cs_table_responsive tr:first-child td,
.cs_table_responsive tr:first-child th {
    background: #eef4ff !important;
    color: #02234f !important;
    font-weight: 700 !important;
    border-top: none !important;
    border-bottom: 2px solid #bfdbfe !important;
    white-space: nowrap;
}

.cs_table_responsive tr:nth-child(even) td {
    background: #f8fafc;
}

/* Sidebar Recent Articles */
.cs_blog_sidebar {
    position: -webkit-sticky;
    position: sticky;
    top: 90px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(2, 35, 79, 0.04);
}

.cs_sidebar_heading {
    padding-bottom: 12px;
    border-bottom: 1.5px solid #f1f5f9;
    color: #02234f;
}

.cs_recent_articles_list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.cs_recent_article_item {
    display: flex;
    align-items: center;
    gap: 14px;
    text-decoration: none;
    padding-bottom: 14px;
    border-bottom: 1px solid #f8fafc;
    transition: transform 0.2s;
}

.cs_recent_article_item:last-child {
    padding-bottom: 0;
    border-bottom: none;
}

.cs_recent_article_item:hover {
    transform: translateX(4px);
}

.cs_recent_article_thumb {
    width: 84px;
    height: 70px;
    object-fit: cover;
    border-radius: 10px;
    flex-shrink: 0;
}

.cs_recent_article_body {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.cs_recent_article_title {
    font-size: 15px;
    font-weight: 600;
    color: #02234f;
    line-height: 1.35;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    transition: color 0.2s;
}

.cs_recent_article_item:hover .cs_recent_article_title {
    color: #fc9502;
}

.cs_recent_article_date {
    font-size: 12px;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* MOBILE ONLY STYLES (max-width: 767px) */
@media (max-width: 767px) {
    .cs_page_header_title {
        font-size: 26px !important;
        line-height: 1.3 !important;
    }

    .cs_blog_article_card {
        padding: 20px 14px;
        border-radius: 14px;
        overflow: hidden;
    }

    /* Table correction specifically for mobile */
    .cs_table_responsive {
        margin: 16px 0 20px 0;
        border-radius: 10px;
    }

    .cs_table_responsive table {
        min-width: 520px !important;
    }

    .cs_table_responsive th,
    .cs_table_responsive td {
        padding: 9px 11px !important;
        font-size: 13px !important;
        min-width: 105px;
    }

    .cs_table_responsive td p,
    .cs_table_responsive th p {
        font-size: 13px !important;
        line-height: 1.45 !important;
        margin-bottom: 0 !important;
    }

    /* Sticky first column (Comparison factor) on mobile */
    .cs_table_responsive td:first-child,
    .cs_table_responsive th:first-child {
        position: -webkit-sticky;
        position: sticky;
        left: 0;
        background: #ffffff;
        font-weight: 600;
        color: #02234f;
        min-width: 115px;
        z-index: 2;
        box-shadow: 2px 0 6px -2px rgba(2, 35, 79, 0.12);
        border-right: 1px solid #cbd5e1 !important;
    }

    .cs_table_responsive tr:first-child td:first-child,
    .cs_table_responsive tr:first-child th:first-child {
        background: #eef4ff !important;
        z-index: 3;
    }

    .cs_table_responsive tr:nth-child(even) td:first-child {
        background: #f8fafc;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ensure all tables inside .cs_blog_content have the responsive wrapper
    const content = document.querySelector('.cs_blog_content');
    if (content) {
        content.querySelectorAll('table').forEach(table => {
            if (!table.closest('.cs_table_responsive')) {
                const resp = document.createElement('div');
                resp.className = 'cs_table_responsive';
                table.parentNode.insertBefore(resp, table);
                resp.appendChild(table);
            }
        });
    }
});
</script>
@endsection
