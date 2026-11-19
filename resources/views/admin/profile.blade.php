@extends('admin.layout', ['title' => 'My Profile'])

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1">My Administrator Account</h3>
        <p class="text-muted small mb-0">Update your name, login email credentials, and security password.</p>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Admin Info Card -->
    <div class="col-lg-4">
        <div class="ds-card p-4 text-center">
            <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center fw-bold fs-2 mb-3 shadow" style="width:72px;height:72px">
                {{ strtoupper(substr($admin->name ?? 'A', 0, 1)) }}
            </div>
            <h5 class="fw-bold mb-1">{{ $admin->name ?? 'Administrator' }}</h5>
            <p class="text-muted small mb-3">{{ $admin->email ?? '' }}</p>
            <span class="ds-badge ds-badge-primary">Super Administrator</span>
            <hr class="my-4">
            <div class="small text-muted text-start">
                <div class="mb-2"><i class="ri-shield-user-line me-2 text-primary"></i> Full CMS Access</div>
                <div class="mb-2"><i class="ri-calendar-line me-2 text-success"></i> Registered: {{ date('M d, Y', strtotime($admin->created_at ?? now())) }}</div>
                <div><i class="ri-history-line me-2 text-warning"></i> Last updated: {{ date('M d, Y', strtotime($admin->updated_at ?? now())) }}</div>
            </div>
        </div>
    </div>

    <!-- Right Column: Profile Edit Form -->
    <div class="col-lg-8">
        <form method="post" action="{{ dura_admin('profile') }}">
            {!! csrf_field() !!}

            <div class="ds-card">
                <div class="ds-card-header">
                    <h5 class="fw-bold mb-0">Profile Information & Security</h5>
                </div>
                <div class="p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <label class="form-label small fw-bold text-dark">Full Name <span class="text-danger">*</span></label>
                            <input class="form-control" name="name" value="{{ old('name', $admin->name) }}" required placeholder="Your full name">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small fw-bold text-dark">Email Address (Login) <span class="text-danger">*</span></label>
                            <input class="form-control" type="email" name="email" value="{{ old('email', $admin->email) }}" required placeholder="admin@durasetu.com">
                        </div>
                    </div>

                    <h6 class="fw-bold text-dark mb-3 pt-3 border-top">Change Password</h6>
                    <p class="small text-muted mb-3">Leave blank if you do not wish to change your current password.</p>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <label class="form-label small fw-bold text-dark">New Password</label>
                            <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Minimum 8 characters">
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small fw-bold text-dark">Confirm New Password</label>
                            <input class="form-control" type="password" name="password_confirmation" autocomplete="new-password" placeholder="Re-type new password">
                        </div>
                    </div>
                </div>

                <div class="ds-card-header bg-white border-top p-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-sm px-4 d-inline-flex align-items-center gap-2 shadow-sm">
                        <i class="ri-check-line"></i> Save Profile Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
