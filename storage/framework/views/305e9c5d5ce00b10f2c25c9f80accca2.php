<?php $__env->startSection('content'); ?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1">Global Settings & Integrations</h3>
        <p class="text-muted small mb-0">Configure site branding, contact channels, SEO tags, analytics tracking codes, and email notifications.</p>
    </div>
</div>

<form method="post" action="<?php echo e(dura_admin('settings')); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>


    <div class="ds-card">
        <!-- Tabs Header -->
        <div class="ds-card-header p-2 px-3">
            <ul class="nav nav-pills gap-1">
                <?php $i = 0; foreach ($groups as $g => $fs): $i++; ?>
                    <?php
                    $tabIcon = match ($g) {
                        'General' => 'ri-store-2-line',
                        'SEO' => 'ri-search-eye-line',
                        'Scripts & custom CSS' => 'ri-code-s-slash-line',
                        'Turnstile (Cloudflare)' => 'ri-shield-keyhole-line',
                        'Leads & email' => 'ri-mail-settings-line',
                        'Robots.txt' => 'ri-robot-line',
                        default => 'ri-settings-line',
                    };
                    ?>
                    <li class="nav-item">
                        <button type="button" class="nav-link py-2 px-3 small fw-semibold <?= $i === 1 ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab_s_<?php echo e($i); ?>">
                            <i class="<?php echo e($tabIcon); ?> me-1"></i> <?php echo e($g); ?>

                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Tabs Content Body -->
        <div class="ds-card-body p-4">
            <div class="tab-content">
                <?php $i = 0; foreach ($groups as $g => $fs): $i++; ?>
                    <div class="tab-pane fade <?= $i === 1 ? 'show active' : '' ?>" id="tab_s_<?php echo e($i); ?>">
                        <div class="row g-3">
                            <?php foreach ($fs as $k => [$label, $type]): ?>
                                <?php
                                $v = old($k, setting($k, ''));
                                $isFull = in_array($type, ['textarea', 'code']) || in_array($k, ['address', 'robots_txt', 'autoreply_body']);
                                $colClass = $isFull ? 'col-12' : 'col-md-6';
                                ?>
                                <div class="<?php echo e($colClass); ?>">
                                    <label class="form-label small fw-bold text-dark mb-1" for="set_<?php echo e($k); ?>"><?php echo e($label); ?></label>

                                    <?php if ($type === 'textarea' || $type === 'code'): ?>
                                        <textarea class="form-control form-control-sm <?= $type === 'code' ? 'font-monospace' : '' ?>" id="set_<?php echo e($k); ?>" name="<?php echo e($k); ?>" rows="<?= $type === 'code' ? 8 : 4 ?>" style="<?= $type === 'code' ? 'font-size:12px;background:#f8fafc;' : '' ?>"><?php echo e($v); ?></textarea>

                                    <?php elseif ($type === 'image'): ?>
                                        <div class="border rounded-3 p-2 bg-light">
                                            <div class="d-flex gap-3 align-items-center">
                                                <?php if ($v): ?>
                                                    <img class="table-logo" style="width:70px;height:45px" src="<?php echo e(dura_path($v)); ?>" alt="Preview" onerror="this.src='<?php echo e(asset('assets/img/logo/logo.png')); ?>'">
                                                <?php else: ?>
                                                    <div class="table-logo d-flex align-items-center justify-content-center text-muted" style="width:70px;height:45px">
                                                        <i class="ri-image-line fs-4"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="flex-grow-1">
                                                    <input type="file" class="form-control form-control-sm mb-1" name="<?php echo e($k); ?>_file" accept="image/*">
                                                    <input type="text" class="form-control form-control-sm font-monospace text-muted" name="<?php echo e($k); ?>" value="<?php echo e($v); ?>" placeholder="Asset path: /assets/img/logo/logo.png" style="font-size:11px">
                                                </div>
                                            </div>
                                        </div>

                                    <?php else: ?>
                                        <input type="<?= $type === 'password' ? 'password' : 'text' ?>" class="form-control form-control-sm" id="set_<?php echo e($k); ?>" name="<?php echo e($k); ?>" value="<?php echo e($v); ?>" autocomplete="off">
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sticky Footer -->
        <div class="ds-card-header bg-white border-top p-3 d-flex justify-content-between align-items-center">
            <span class="small text-muted">Changes apply immediately across the portal.</span>
            <button type="submit" class="btn btn-primary btn-sm px-4 d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="ri-save-line"></i> Save All Settings
            </button>
        </div>
    </div>
</form>

<!-- Mail Test Card -->
<div class="ds-card mt-4 border-info border-opacity-25">
    <div class="p-3 d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3">
        <div>
            <div class="fw-bold small text-dark"><i class="ri-mail-check-line text-info me-1"></i> Test SMTP Configuration</div>
            <div class="text-muted" style="font-size:0.78rem">Send a test email to verify that your configured SMTP mail server is sending enquiry notifications properly.</div>
        </div>
        <form method="post" action="<?php echo e(dura_admin('settings/test-mail')); ?>" class="m-0">
            <?php echo csrf_field(); ?>

            <button type="submit" class="btn btn-sm btn-outline-info text-dark d-inline-flex align-items-center gap-1">
                <i class="ri-send-plane-line"></i> Send Test Email
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout', ['title' => 'Settings & Scripts'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\dashboard\dura-setu-laravel\resources\views/admin/settings.blade.php ENDPATH**/ ?>