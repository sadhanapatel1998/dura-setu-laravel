<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?php echo e($title ?? 'Admin'); ?> | <?php echo e(setting('site_name', 'DuraSetu')); ?> CMS</title>
    
    <!-- Google Font: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 & Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    
    <style>
        :root {
            --ds-font: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            --ds-bg: #f8fafc;
            --ds-sidebar-bg: #0f172a;
            --ds-sidebar-hover: #1e293b;
            --ds-sidebar-active: #2563eb;
            --ds-primary: #2563eb;
            --ds-primary-hover: #1d4ed8;
            --ds-border: #e2e8f0;
            --ds-card-bg: #ffffff;
            --ds-text: #1e293b;
            --ds-text-muted: #64748b;
        }

        body {
            font-family: var(--ds-font);
            background-color: var(--ds-bg);
            color: var(--ds-text);
            min-height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .admin-sidebar {
            width: 260px;
            min-height: 100vh;
            background: var(--ds-sidebar-bg);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1030;
            transition: transform 0.3s ease, width 0.3s ease;
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.08);
            overflow-y: auto;
        }

        .admin-sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .admin-sidebar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 4px;
        }

        .sidebar-brand {
            padding: 1.25rem 1.25rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.07);
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #ffffff;
            text-decoration: none;
        }

        .sidebar-brand-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #2563eb, #38bdf8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }

        .sidebar-brand-text {
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
        }
        .sidebar-brand-badge {
            font-size: 0.65rem;
            text-transform: uppercase;
            padding: 2px 6px;
            background: rgba(37, 99, 235, 0.2);
            color: #60a5fa;
            border-radius: 4px;
            font-weight: 600;
        }

        .sidebar-section-title {
            padding: 1rem 1.25rem 0.35rem;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #94a3b8;
        }

        .sidebar-nav {
            padding: 0.5rem 0.75rem;
            list-style: none;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.65rem 0.85rem;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 500;
            margin-bottom: 2px;
            transition: all 0.15s ease;
        }

        .sidebar-nav-link i {
            font-size: 1.15rem;
            color: #94a3b8;
            transition: color 0.15s ease;
        }

        .sidebar-nav-link:hover {
            background-color: var(--ds-sidebar-hover);
            color: #ffffff;
        }
        .sidebar-nav-link:hover i {
            color: #60a5fa;
        }

        .sidebar-nav-link.active {
            background-color: var(--ds-sidebar-active);
            color: #ffffff;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }
        .sidebar-nav-link.active i {
            color: #ffffff;
        }

        .sidebar-footer {
            padding: 1rem 1.25rem;
            border-top: 1px solid rgba(255, 255, 255, 0.07);
            background: rgba(0, 0, 0, 0.15);
        }

        /* Topbar Header */
        .admin-main {
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .admin-topbar {
            height: 64px;
            background: #ffffff;
            border-bottom: 1px solid var(--ds-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1.5rem;
            position: sticky;
            top: 0;
            z-index: 1020;
        }

        .topbar-toggle {
            background: none;
            border: 1px solid var(--ds-border);
            border-radius: 8px;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: var(--ds-text);
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .topbar-toggle:hover {
            background: #f1f5f9;
        }

        .admin-content-area {
            padding: 1.75rem 1.75rem 3rem;
            flex-grow: 1;
        }

        /* Card Styles */
        .ds-card {
            background: var(--ds-card-bg);
            border: 1px solid var(--ds-border);
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.04);
            margin-bottom: 1.5rem;
        }

        .ds-card-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--ds-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fafbfc;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }

        .ds-card-body {
            padding: 1.25rem;
        }

        /* Table Styling */
        .ds-table {
            margin-bottom: 0;
            font-size: 0.88rem;
        }

        .ds-table th {
            background: #f8fafc;
            color: var(--ds-text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.72rem;
            letter-spacing: 0.05em;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--ds-border);
            white-space: nowrap;
        }

        .ds-table td {
            padding: 0.85rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .ds-table tr:hover td {
            background-color: #f8fafc;
        }

        .table-thumb {
            width: 48px;
            height: 48px;
            object-fit: cover;
            border-radius: 8px;
            background: #f1f5f9;
            border: 1px solid var(--ds-border);
        }

        .table-logo {
            width: 54px;
            height: 38px;
            object-fit: contain;
            border-radius: 6px;
            background: #ffffff;
            border: 1px solid var(--ds-border);
            padding: 2px;
        }

        /* Badges */
        .ds-badge {
            font-size: 0.75rem;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .ds-badge-success { background: #dcfce7; color: #15803d; }
        .ds-badge-secondary { background: #f1f5f9; color: #475569; }
        .ds-badge-danger { background: #fee2e2; color: #b91c1c; }
        .ds-badge-warning { background: #fef3c7; color: #b45309; }
        .ds-badge-info { background: #e0f2fe; color: #0369a1; }
        .ds-badge-primary { background: #dbeafe; color: #1d4ed8; }

        /* Action Buttons */
        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            border: 1px solid var(--ds-border);
            background: #ffffff;
            color: #475569;
            transition: all 0.15s ease;
        }
        .btn-action:hover {
            background: #f1f5f9;
            color: var(--ds-primary);
            border-color: #cbd5e1;
        }
        .btn-action-danger:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fca5a5;
        }

        /* Filter bar */
        .filter-card {
            background: #ffffff;
            border: 1px solid var(--ds-border);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1.25rem;
        }

        /* Pagination styling */
        .pagination {
            gap: 4px;
            margin-bottom: 0;
        }
        .page-link {
            border-radius: 8px !important;
            border: 1px solid var(--ds-border);
            color: #475569;
            font-weight: 500;
            padding: 0.45rem 0.85rem;
            font-size: 0.88rem;
        }
        .page-item.active .page-link {
            background-color: var(--ds-primary);
            border-color: var(--ds-primary);
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.3);
        }
        .page-link:hover {
            background-color: #f1f5f9;
            color: var(--ds-primary);
        }

        /* Mobile Backdrop */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(2px);
            z-index: 1025;
        }

        @media (max-width: 991.98px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.show {
                transform: translateX(0);
            }
            .admin-main {
                margin-left: 0 !important;
            }
            .sidebar-backdrop.show {
                display: block;
            }
        }
    </style>
</head>
<body>

<?php
$cur = '/' . trim(request()->path(), '/');
$leadCount = $newLeadsCount ?? 0;
?>

<!-- Mobile Sidebar Backdrop -->
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>

<!-- Sidebar -->
<aside class="admin-sidebar" id="adminSidebar">
    <a href="<?php echo e(dura_admin()); ?>" class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <i class="ri-graduation-cap-fill"></i>
        </div>
        <div>
            <div class="sidebar-brand-text"><?php echo e(setting('site_name', 'DuraSetu')); ?></div>
            <span class="sidebar-brand-badge">CMS Portal</span>
        </div>
    </a>

    <div class="sidebar-section-title">Core Management</div>
    <ul class="sidebar-nav">
        <li>
            <a href="<?php echo e(dura_admin()); ?>" class="sidebar-nav-link <?= $cur === '/admin' ? 'active' : '' ?>">
                <i class="ri-dashboard-3-line"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(dura_admin('leads')); ?>" class="sidebar-nav-link <?= strpos($cur, '/admin/leads') === 0 ? 'active' : '' ?>">
                <i class="ri-contacts-book-line"></i>
                <span class="flex-grow-1">Contact Leads</span>
                <?php if ($leadCount > 0): ?>
                    <span class="badge rounded-pill bg-danger"><?php echo e($leadCount); ?></span>
                <?php endif; ?>
            </a>
        </li>
    </ul>

    <div class="sidebar-section-title">Academics & Content</div>
    <ul class="sidebar-nav">
        <li>
            <a href="<?php echo e(dura_admin('universities')); ?>" class="sidebar-nav-link <?= strpos($cur, '/admin/universities') === 0 ? 'active' : '' ?>">
                <i class="ri-building-line"></i>
                <span>Universities</span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(dura_admin('courses')); ?>" class="sidebar-nav-link <?= strpos($cur, '/admin/courses') === 0 ? 'active' : '' ?>">
                <i class="ri-book-open-line"></i>
                <span>Courses</span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(dura_admin('blogs')); ?>" class="sidebar-nav-link <?= strpos($cur, '/admin/blogs') === 0 ? 'active' : '' ?>">
                <i class="ri-article-line"></i>
                <span>Blogs</span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(dura_admin('sliders')); ?>" class="sidebar-nav-link <?= strpos($cur, '/admin/sliders') === 0 ? 'active' : '' ?>">
                <i class="ri-slideshow-3-line"></i>
                <span>Home Sliders</span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(dura_admin('testimonials')); ?>" class="sidebar-nav-link <?= strpos($cur, '/admin/testimonials') === 0 ? 'active' : '' ?>">
                <i class="ri-chat-quote-line"></i>
                <span>Testimonials</span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(dura_admin('faqs')); ?>" class="sidebar-nav-link <?= strpos($cur, '/admin/faqs') === 0 ? 'active' : '' ?>">
                <i class="ri-questionnaire-line"></i>
                <span>FAQs</span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(dura_admin('pages')); ?>" class="sidebar-nav-link <?= strpos($cur, '/admin/pages') === 0 ? 'active' : '' ?>">
                <i class="ri-file-text-line"></i>
                <span>Pages & SEO</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-section-title">Configuration</div>
    <ul class="sidebar-nav">
        <li>
            <a href="<?php echo e(dura_admin('settings')); ?>" class="sidebar-nav-link <?= strpos($cur, '/admin/settings') === 0 ? 'active' : '' ?>">
                <i class="ri-settings-4-line"></i>
                <span>Settings & Scripts</span>
            </a>
        </li>
        <li>
            <a href="<?php echo e(dura_admin('profile')); ?>" class="sidebar-nav-link <?= strpos($cur, '/admin/profile') === 0 ? 'active' : '' ?>">
                <i class="ri-user-settings-line"></i>
                <span>My Profile</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2 overflow-hidden">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:34px;height:34px;font-size:0.85rem;font-weight:700">
                    <?php echo e(strtoupper(substr($admin->name ?? 'A', 0, 1))); ?>

                </div>
                <div class="overflow-hidden">
                    <div class="text-white small fw-bold text-truncate"><?php echo e($admin->name ?? 'Administrator'); ?></div>
                    <div class="text-white-50 small text-truncate" style="font-size:0.75rem"><?php echo e($admin->email ?? ''); ?></div>
                </div>
            </div>
            <form method="post" action="<?php echo e(dura_admin('logout')); ?>" class="m-0">
                <?php echo csrf_field(); ?>

                <button type="submit" class="btn btn-sm btn-outline-danger p-1 px-2" title="Logout">
                    <i class="ri-logout-box-r-line"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Main Wrapper -->
<div class="admin-main">
    <!-- Topbar -->
    <header class="admin-topbar">
        <div class="d-flex align-items-center gap-3">
            <button type="button" class="topbar-toggle" id="sidebarToggle" aria-label="Toggle Sidebar">
                <i class="ri-menu-2-line"></i>
            </button>
            <div class="d-none d-sm-block">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 small">
                        <li class="breadcrumb-item"><a href="<?php echo e(dura_admin()); ?>" class="text-decoration-none text-muted">Admin</a></li>
                        <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page"><?php echo e($title ?? 'Dashboard'); ?></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="d-flex align-items-center gap-3">
            <a href="<?php echo e(url('/')); ?>" target="_blank" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1">
                <i class="ri-external-link-line"></i>
                <span class="d-none d-sm-inline">Live Website</span>
            </a>

            <div class="dropdown">
                <button class="btn btn-light btn-sm d-flex align-items-center gap-2 border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:26px;height:26px;font-size:0.75rem;font-weight:700">
                        <?php echo e(strtoupper(substr($admin->name ?? 'A', 0, 1))); ?>

                    </div>
                    <span class="small fw-semibold d-none d-md-inline"><?php echo e($admin->name ?? 'Admin'); ?></span>
                    <i class="ri-arrow-down-s-line text-muted"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                    <li class="px-3 py-2 border-bottom">
                        <div class="fw-bold text-dark"><?php echo e($admin->name ?? 'Admin'); ?></div>
                        <div class="small text-muted"><?php echo e($admin->email ?? ''); ?></div>
                    </li>
                    <li><a class="dropdown-item py-2" href="<?php echo e(dura_admin('profile')); ?>"><i class="ri-user-3-line me-2 text-muted"></i> My Profile</a></li>
                    <li><a class="dropdown-item py-2" href="<?php echo e(dura_admin('settings')); ?>"><i class="ri-settings-4-line me-2 text-muted"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="post" action="<?php echo e(dura_admin('logout')); ?>" class="m-0">
                            <?php echo csrf_field(); ?>

                            <button class="dropdown-item py-2 text-danger"><i class="ri-logout-box-r-line me-2"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Content Area -->
    <main class="admin-content-area">
        <?php if (function_exists('session') && session('ok')): ?>
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm" role="alert">
                <i class="ri-checkbox-circle-fill fs-5 text-success"></i>
                <div class="flex-grow-1"><?php echo e(session('ok')); ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (function_exists('session') && session('err')): ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2 border-0 shadow-sm" role="alert">
                <i class="ri-error-warning-fill fs-5 text-danger"></i>
                <div class="flex-grow-1"><?php echo e(session('err')); ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($errors) && $errors->any()): ?>
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                <div class="d-flex align-items-center gap-2 fw-bold mb-1">
                    <i class="ri-error-warning-fill fs-5"></i> Please correct the following errors:
                </div>
                <ul class="mb-0 ps-3 small">
                    <?php foreach ($errors->all() as $er): ?>
                        <li><?php echo e($er); ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('sidebarToggle');
        const sidebar = document.getElementById('adminSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');

        if (toggleBtn && sidebar) {
            toggleBtn.addEventListener('click', function () {
                sidebar.classList.toggle('show');
                if (backdrop) backdrop.classList.toggle('show');
            });
        }

        if (backdrop) {
            backdrop.addEventListener('click', function () {
                sidebar.classList.remove('show');
                backdrop.classList.remove('show');
            });
        }
    });
</script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\dashboard\dura-setu-laravel\resources\views/admin/layout.blade.php ENDPATH**/ ?>