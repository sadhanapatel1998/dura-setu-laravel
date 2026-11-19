@extends('admin.layout', ['title' => 'Dashboard Overview'])

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1">Welcome back, {{ $admin->name ?? 'Admin' }}! 👋</h3>
        <p class="text-muted small mb-0">Here is the latest summary of your DuraSetu educational portal.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ dura_admin('leads') }}" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1">
            <i class="ri-contacts-book-line"></i> View Leads
            <?php if (($stats['new_leads'] ?? 0) > 0): ?>
                <span class="badge bg-danger rounded-pill ms-1">{{ $stats['new_leads'] }}</span>
            <?php endif; ?>
        </a>
        <a href="{{ dura_admin('universities/create') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
            <i class="ri-add-line"></i> Add University
        </a>
        <a href="{{ dura_admin('courses/create') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
            <i class="ri-add-line"></i> Add Course
        </a>
    </div>
</div>

<!-- Primary Stats Grid -->
<div class="row g-3 mb-4">
    <!-- Leads Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="ds-card p-3 h-100 position-relative overflow-hidden">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold text-uppercase">Total Leads</span>
                <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-2">
                    <i class="ri-user-star-line fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <h2 class="fw-bold mb-0">{{ number_format($stats['total_leads'] ?? 0) }}</h2>
                <?php if (($stats['new_leads'] ?? 0) > 0): ?>
                    <span class="ds-badge ds-badge-danger">
                        <i class="ri-notification-3-fill"></i> {{ $stats['new_leads'] }} new
                    </span>
                <?php else: ?>
                    <span class="ds-badge ds-badge-secondary">All caught up</span>
                <?php endif; ?>
            </div>
            <div class="mt-2 text-muted small">
                Converted: <span class="fw-bold text-success">{{ $stats['converted_leads'] ?? 0 }}</span> · Contacted: <span class="fw-bold text-primary">{{ $stats['contacted_leads'] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Universities Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="ds-card p-3 h-100 position-relative overflow-hidden">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold text-uppercase">Universities</span>
                <div class="rounded-3 bg-success bg-opacity-10 text-success p-2">
                    <i class="ri-building-line fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <h2 class="fw-bold mb-0">{{ number_format($stats['universities'] ?? 0) }}</h2>
                <span class="ds-badge ds-badge-success"><i class="ri-check-line"></i> Published</span>
            </div>
            <div class="mt-2 text-muted small">
                <a href="{{ dura_admin('universities') }}" class="text-decoration-none">Manage universities &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Courses Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="ds-card p-3 h-100 position-relative overflow-hidden">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold text-uppercase">Courses</span>
                <div class="rounded-3 bg-info bg-opacity-10 text-info p-2">
                    <i class="ri-book-open-line fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <h2 class="fw-bold mb-0">{{ number_format($stats['courses'] ?? 0) }}</h2>
                <span class="ds-badge ds-badge-info">UG & PG</span>
            </div>
            <div class="mt-2 text-muted small">
                <a href="{{ dura_admin('courses') }}" class="text-decoration-none">Manage courses &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Blogs Card -->
    <div class="col-sm-6 col-xl-3">
        <div class="ds-card p-3 h-100 position-relative overflow-hidden">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-muted small fw-semibold text-uppercase">Articles & Blogs</span>
                <div class="rounded-3 bg-warning bg-opacity-10 text-warning p-2">
                    <i class="ri-article-line fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-baseline gap-2">
                <h2 class="fw-bold mb-0">{{ number_format($stats['blogs'] ?? 0) }}</h2>
                <span class="ds-badge ds-badge-warning">Published</span>
            </div>
            <div class="mt-2 text-muted small">
                <a href="{{ dura_admin('blogs') }}" class="text-decoration-none">Manage articles &rarr;</a>
            </div>
        </div>
    </div>
</div>

<!-- Secondary Stats Pills -->
<div class="row g-2 mb-4">
    <div class="col-6 col-md-3">
        <div class="ds-card p-2 px-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="ri-slideshow-3-line text-muted"></i>
                <span class="small fw-semibold">Sliders</span>
            </div>
            <span class="badge bg-light text-dark border">{{ $stats['sliders'] ?? 0 }}</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="ds-card p-2 px-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="ri-chat-quote-line text-muted"></i>
                <span class="small fw-semibold">Testimonials</span>
            </div>
            <span class="badge bg-light text-dark border">{{ $stats['testimonials'] ?? 0 }}</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="ds-card p-2 px-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="ri-questionnaire-line text-muted"></i>
                <span class="small fw-semibold">FAQs</span>
            </div>
            <span class="badge bg-light text-dark border">{{ $stats['faqs'] ?? 0 }}</span>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="ds-card p-2 px-3 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="ri-settings-line text-muted"></i>
                <span class="small fw-semibold">Settings</span>
            </div>
            <a href="{{ dura_admin('settings') }}" class="small text-decoration-none">Configure &rarr;</a>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Recent Leads -->
    <div class="col-lg-7">
        <div class="ds-card h-100">
            <div class="ds-card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="ri-contacts-book-line text-primary"></i>
                    <h5 class="fw-bold mb-0">Latest Enquiries</h5>
                </div>
                <a href="{{ dura_admin('leads') }}" class="btn btn-sm btn-outline-secondary">View All Leads &rarr;</a>
            </div>
            <div class="table-responsive">
                <table class="table ds-table mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($latest_leads) > 0): ?>
                            <?php foreach ($latest_leads as $lead): ?>
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $lead->name }}</div>
                                        <div class="text-muted small" style="font-size:0.75rem">
                                            {{ date('M d, Y h:i A', strtotime($lead->created_at)) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="small fw-medium">
                                            <a href="tel:{{ $lead->phone }}" class="text-decoration-none text-dark">
                                                <i class="ri-phone-line text-muted"></i> {{ $lead->phone }}
                                            </a>
                                        </div>
                                        <div class="small text-muted" style="font-size:0.75rem">
                                            <i class="ri-mail-line"></i> {{ $lead->email }}
                                        </div>
                                    </td>
                                    <td>
                                        <?php
                                        $badgeClass = match ($lead->status) {
                                            'new' => 'ds-badge-danger',
                                            'contacted' => 'ds-badge-info',
                                            'converted' => 'ds-badge-success',
                                            default => 'ds-badge-secondary',
                                        };
                                        ?>
                                        <span class="ds-badge {{ $badgeClass }}">
                                            {{ ucfirst($lead->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ dura_admin('leads/' . $lead->id) }}" class="btn btn-sm btn-light border" title="View Details">
                                            <i class="ri-arrow-right-line"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="ri-inbox-line fs-2 d-block mb-1 text-secondary"></i>
                                    No enquiries received yet.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Right Column: Quick Content -->
    <div class="col-lg-5">
        <!-- Recent Universities -->
        <div class="ds-card mb-4">
            <div class="ds-card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="ri-building-line text-success"></i>
                    <h5 class="fw-bold mb-0">Universities</h5>
                </div>
                <a href="{{ dura_admin('universities') }}" class="btn btn-sm btn-outline-secondary">All &rarr;</a>
            </div>
            <div class="p-3">
                <ul class="list-group list-group-flush">
                    <?php foreach ($recent_universities as $uni): ?>
                        <li class="list-group-item px-0 d-flex align-items-center justify-content-between border-bottom">
                            <div class="d-flex align-items-center gap-2">
                                <?php if (!empty($uni->logo)): ?>
                                    <img src="{{ dura_path($uni->logo) }}" alt="" class="table-logo" style="width:40px;height:28px">
                                <?php else: ?>
                                    <div class="rounded bg-light border d-flex align-items-center justify-content-center" style="width:40px;height:28px">
                                        <i class="ri-building-line text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <div class="fw-semibold small text-dark">{{ $uni->name }}</div>
                                    <div class="text-muted small" style="font-size:0.75rem">/{{ $uni->slug }}</div>
                                </div>
                            </div>
                            <a href="{{ dura_admin('universities/' . $uni->id . '/edit') }}" class="btn btn-sm btn-action">
                                <i class="ri-edit-line"></i>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- System & SEO Quick Links -->
        <div class="ds-card">
            <div class="ds-card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="ri-links-line text-primary"></i>
                    <h5 class="fw-bold mb-0">Quick Utilities</h5>
                </div>
            </div>
            <div class="p-3">
                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ url('sitemap.xml') }}" target="_blank" class="btn btn-light border w-100 text-start py-2">
                            <div class="small fw-semibold"><i class="ri-git-merge-line me-1 text-primary"></i> Sitemap.xml</div>
                            <div class="text-muted" style="font-size:0.72rem">Auto-generated XML</div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ url('robots.txt') }}" target="_blank" class="btn btn-light border w-100 text-start py-2">
                            <div class="small fw-semibold"><i class="ri-robot-line me-1 text-success"></i> Robots.txt</div>
                            <div class="text-muted" style="font-size:0.72rem">Crawler instructions</div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ dura_admin('pages') }}" class="btn btn-light border w-100 text-start py-2">
                            <div class="small fw-semibold"><i class="ri-search-eye-line me-1 text-warning"></i> SEO Pages</div>
                            <div class="text-muted" style="font-size:0.72rem">Meta titles & tags</div>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ dura_admin('settings') }}" class="btn btn-light border w-100 text-start py-2">
                            <div class="small fw-semibold"><i class="ri-mail-send-line me-1 text-info"></i> SMTP & Mail</div>
                            <div class="text-muted" style="font-size:0.72rem">Lead notification alert</div>
                        </a>
                    </div>
                    <div class="col-6">
                        <form method="post" action="{{ dura_admin('clear-cache') }}" class="m-0">
                            {!! csrf_field() !!}
                            <button type="submit" class="btn btn-light border w-100 text-start py-2">
                                <div class="small fw-semibold"><i class="ri-delete-bin-line me-1 text-danger"></i> Clear Cache</div>
                                <div class="text-muted" style="font-size:0.72rem">Run optimize:clear</div>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
