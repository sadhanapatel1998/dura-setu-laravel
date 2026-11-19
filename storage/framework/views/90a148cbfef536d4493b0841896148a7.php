
<?php $__env->startSection('content'); ?>
<main>
    <section class="cs_page_header cs_bg_filed" data-src="<?php echo e(asset('assets/img/breadcrumb-bg.jpg')); ?>">
        <div class="container">
            <div class="cs_page_header_text">
                <h1 class="cs_page_header_title cs_fs_48 cs_bold"><?= htmlspecialchars($blog['title']); ?></h1>
                <ul class="cs_breadcrumb cs_mp_0 cs_fs_16">
                    <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                    <li><a href="<?php echo e(url('blogs')); ?>">Blogs</a></li>
                    <li><?= htmlspecialchars($blog['title']); ?></li>
                </ul>
            </div>
        </div>
    </section>

    <section class="cs_section_padding">
        <div class="container">
            <div class="row cs_gap_y_40">
                <div class="col-lg-8">
                    <article class="cs_blog_article">
                        <?php if ($blog['image']): ?>
                        <img src="<?= htmlspecialchars(dura_path($blog['image'])); ?>" alt="<?= htmlspecialchars($blog['title']); ?>" class="w-100 cs_radius_20 mb-4" style="max-height:440px;object-fit:cover">
                        <?php endif; ?>
                        <p class="cs_fs_14 mb-3">
                            <?php if ($blog['category']): ?><span class="cs_primary_color cs_semibold"><?= htmlspecialchars($blog['category']); ?></span> &middot; <?php endif; ?>
                            <time datetime="<?= date('Y-m-d', strtotime($blog['published_at'] ?: 'now')); ?>"><?= date('d M Y', strtotime($blog['published_at'] ?: 'now')); ?></time>
                            <?php if ($blog['author']): ?> &middot; <?= htmlspecialchars($blog['author']); ?><?php endif; ?>
                        </p>
                        <div class="cs_blog_content"><?= dura_fix_html($blog['content']); ?></div>
                    </article>
                    <div class="mt-5">
                        <a href="<?php echo e(url('contact')); ?>" class="cs_uni_card_btn d-inline-block">Get Free Counselling</a>
                    </div>
                </div>
                <aside class="col-lg-4">
                    <h2 class="cs_fs_24 cs_semibold mb-3">Recent Articles</h2>
                    <?php foreach ($recent as $rb): ?>
                    <a href="<?= htmlspecialchars($rb['url']); ?>" class="d-flex gap-3 mb-3 text-decoration-none">
                        <img src="<?= htmlspecialchars($rb['image']); ?>" alt="<?= htmlspecialchars($rb['title']); ?>" loading="lazy" style="width:90px;height:70px;object-fit:cover;border-radius:10px">
                        <span class="cs_fs_16 cs_semibold"><?= htmlspecialchars($rb['title']); ?></span>
                    </a>
                    <?php endforeach; ?>
                </aside>
            </div>
        </div>
    </section>
</main>
<style>.cs_blog_content{font-size:17px;line-height:1.8}.cs_blog_content h2,.cs_blog_content h3{margin:1.6rem 0 .8rem}.cs_blog_content img{max-width:100%;height:auto}.cs_blog_content ul,.cs_blog_content ol{padding-left:1.4rem}</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\dura-setu-laravel\resources\views/site/blog-show.blade.php ENDPATH**/ ?>