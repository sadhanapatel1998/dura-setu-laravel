<?php $__env->startSection('content'); ?>
    <?php
        extract(dura_page_data());
    ?>


    <main>
        <!-- Start Page Header -->
        <section class="cs_page_header cs_bg_filed" data-src="<?php echo e(asset('assets/img/breadcrumb-bg.jpg')); ?>">
            <div class="container">
                <div class="cs_page_header_text">
                    <h1 class="cs_page_header_title cs_fs_64">Blogs</h1>
                    <ul class="cs_breadcrumb cs_mp_0 cs_fs_16">
                        <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
                        <li>Blogs</li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- End Page Header -->

        <!-- Start Blog Section -->
        <section class="cs_demo_section cs_section_padding">
            <div class="container">
                <div class="cs_section_heading_style_1 cs_center_column text-center mb-5 aos-init aos-animate"
                    data-aos="fade-up">
                    <h2 class="cs_pop_title cs_fs_42 cs_medium mb-2">
                        Latest <span>Career Insights</span>
                    </h2>
                    <p class="cs_section_subtitle mb-0">
                        Explore expert insights, university updates, course guides,
                        and tips to make smarter decisions about your online education.
                    </p>
                </div>

                <!-- Blog Slider -->
                <div class="cs_demo_slider_wrap slider-section">
                    <div class="row g-4">
                        <?php foreach ($blogs as $blog): ?>
                        <div class="col-md-4">
                            <article class="cs_course_style_4 cs_radius_20">
                                <div class="cs_course_thumbnail cs_radius_15">
                                    <img src="<?= htmlspecialchars($blog['image']); ?>"
                                        alt="<?= htmlspecialchars($blog['title']); ?>" loading="lazy">
                                    <span class="cs_course_badge cs_primary_bg cs_fs_14 cs_white_color">
                                        <?= htmlspecialchars($blog['category']); ?>
                                    </span>

                                </div>
                                <h3 class="cs_course_title cs_fs_20 cs_semibold">
                                    <a href="<?= htmlspecialchars($blog['url']); ?>">
                                        <?= htmlspecialchars($blog['title']); ?>
                                    </a>
                                </h3>
                                <p class="cs_course_text"
                                    style="margin-top: 0; display: block; overflow: visible; font-size: 16px;">
                                    <?= htmlspecialchars($blog['description']); ?>
                                </p>
                            </article>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            </div>
        </section>
        <!-- End Blog Section -->

    </main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.site', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\dura-setu-laravel\resources\views/site/blogs.blade.php ENDPATH**/ ?>