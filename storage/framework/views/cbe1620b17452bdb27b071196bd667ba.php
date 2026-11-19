<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login | <?php echo e(setting('site_name', 'DuraSetu')); ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 1.5rem;
        }

        .login-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            width: 100%;
            max-width: 420px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .login-brand-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #2563eb, #38bdf8);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 8px 16px rgba(37, 99, 235, 0.35);
        }

        .form-control {
            border-radius: 10px;
            padding: 0.65rem 0.9rem;
            font-size: 0.92rem;
            border-color: #cbd5e1;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .btn-primary {
            background: #2563eb;
            border-color: #2563eb;
            border-radius: 10px;
            padding: 0.7rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35);
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="p-4 p-sm-5">
        <div class="text-center mb-4">
            <div class="login-brand-icon">
                <i class="ri-graduation-cap-fill"></i>
            </div>
            <h4 class="fw-bold text-dark mb-1"><?php echo e(setting('site_name', 'DuraSetu')); ?> CMS</h4>
            <p class="text-muted small">Sign in with your administrator credentials</p>
        </div>

        <?php if ($errors->any()): ?>
            <div class="alert alert-danger py-2 small d-flex align-items-center gap-2 border-0 shadow-sm mb-3">
                <i class="ri-error-warning-fill fs-5"></i>
                <div><?php echo e($errors->first()); ?></div>
            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo e(dura_admin('login')); ?>">
            <?php echo csrf_field(); ?>


            <div class="mb-3">
                <label class="form-label small fw-bold text-dark mb-1">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0">
                        <i class="ri-mail-line"></i>
                    </span>
                    <input class="form-control border-start-0" type="email" name="email" value="<?php echo e(old('email', '')); ?>" placeholder="name@durasetu.com" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold text-dark mb-1">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0">
                        <i class="ri-lock-password-line"></i>
                    </span>
                    <input class="form-control border-start-0" type="password" id="loginPassword" name="password" placeholder="••••••••" required>
                    <button class="btn btn-outline-secondary border-start-0 bg-light" type="button" onclick="togglePasswordVisibility()">
                        <i class="ri-eye-line" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center gap-2">
                <span>Sign In to Dashboard</span>
                <i class="ri-arrow-right-line"></i>
            </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top">
            <a href="<?php echo e(url('/')); ?>" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1">
                <i class="ri-arrow-left-line"></i> Return to Live Website
            </a>
        </div>
    </div>
</div>

<script>
function togglePasswordVisibility() {
    const input = document.getElementById('loginPassword');
    const icon = document.getElementById('toggleIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('ri-eye-line');
        icon.classList.add('ri-eye-off-line');
    } else {
        input.type = 'password';
        icon.classList.remove('ri-eye-off-line');
        icon.classList.add('ri-eye-line');
    }
}
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\dashboard\dura-setu-laravel\resources\views/admin/login.blade.php ENDPATH**/ ?>