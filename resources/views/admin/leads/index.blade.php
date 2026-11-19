@extends('admin.layout', ['title' => 'Contact Leads'])

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 d-flex align-items-center gap-2">
            Contact Leads
            <span class="badge bg-light text-dark border fs-6 fw-normal rounded-pill">
                {{ $items->total() }} total
            </span>
        </h3>
        <p class="text-muted small mb-0">View, manage, and follow up with student enquiries submitted through the website.</p>
    </div>
    <div>
        <a class="btn btn-outline-success d-inline-flex align-items-center gap-2 shadow-sm" href="{{ dura_admin('leads/export?' . http_build_query(request()->query())) }}">
            <i class="ri-file-excel-2-line fs-5"></i>
            <span>Export CSV</span>
        </a>
    </div>
</div>

<!-- Status Tabs Pills -->
<div class="d-flex gap-2 flex-wrap mb-3">
    <?php
    $curStatus = request('status', '');
    $tabs = [
        '' => ['All Leads', $statusCounts['all'] ?? 0, 'secondary'],
        'new' => ['New Enquiries', $statusCounts['new'] ?? 0, 'danger'],
        'contacted' => ['Contacted', $statusCounts['contacted'] ?? 0, 'info'],
        'converted' => ['Converted', $statusCounts['converted'] ?? 0, 'success'],
        'closed' => ['Closed', $statusCounts['closed'] ?? 0, 'secondary'],
    ];
    ?>
    <?php foreach ($tabs as $key => [$label, $count, $theme]): ?>
        <?php $isActive = (string)$curStatus === (string)$key; ?>
        <a href="{{ dura_admin('leads?' . http_build_query(array_merge(request()->query(), ['status' => $key, 'page' => 1]))) }}" class="btn btn-sm <?= $isActive ? 'btn-dark' : 'btn-light border' ?> d-inline-flex align-items-center gap-2">
            <span>{{ $label }}</span>
            <span class="badge rounded-pill <?= $isActive ? 'bg-light text-dark' : 'bg-' . $theme ?>">{{ $count }}</span>
        </a>
    <?php endforeach; ?>
</div>

<!-- Filter Bar -->
<div class="filter-card">
    <form method="get" action="{{ dura_admin('leads') }}" class="row g-2 align-items-center">
        <!-- Preserve status if already selected -->
        <?php if (request()->filled('status')): ?>
            <input type="hidden" name="status" value="{{ request('status') }}">
        <?php endif; ?>

        <!-- Search -->
        <div class="col-12 col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0 text-muted">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" class="form-control border-start-0" name="q" value="{{ request('q') }}" placeholder="Search by name, phone, email, message...">
            </div>
        </div>

        <!-- Date Range -->
        <div class="col-6 col-md-2">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0 text-muted small" style="font-size:11px">From</span>
                <input type="date" class="form-control form-control-sm" name="from" value="{{ request('from') }}">
            </div>
        </div>
        <div class="col-6 col-md-2">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0 text-muted small" style="font-size:11px">To</span>
                <input type="date" class="form-control form-control-sm" name="to" value="{{ request('to') }}">
            </div>
        </div>

        <!-- Per Page Selector -->
        <div class="col-6 col-md-2">
            <select class="form-select form-select-sm" name="per_page">
                <option value="10" <?= ($perPage ?? 15) == 10 ? 'selected' : '' ?>>10 per page</option>
                <option value="15" <?= ($perPage ?? 15) == 15 ? 'selected' : '' ?>>15 per page</option>
                <option value="25" <?= ($perPage ?? 15) == 25 ? 'selected' : '' ?>>25 per page</option>
                <option value="50" <?= ($perPage ?? 15) == 50 ? 'selected' : '' ?>>50 per page</option>
                <option value="100" <?= ($perPage ?? 15) == 100 ? 'selected' : '' ?>>100 per page</option>
            </select>
        </div>

        <!-- Filter Submit & Reset -->
        <div class="col-12 col-md-auto ms-auto d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
                <i class="ri-filter-3-line"></i> Filter
            </button>
            <?php if (request()->hasAny(['q', 'from', 'to', 'status'])): ?>
                <a href="{{ dura_admin('leads') }}" class="btn btn-outline-secondary btn-sm" title="Clear Filters">
                    <i class="ri-refresh-line"></i> Reset
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Leads Data Table Card -->
<div class="ds-card">
    <div class="table-responsive">
        <table class="table ds-table mb-0">
            <thead>
                <tr>
                    <th style="width:60px">ID</th>
                    <th>Date & Time</th>
                    <th>Student Info</th>
                    <th>Contact Channels</th>
                    <th>Message</th>
                    <th>Status</th>
                    <th class="text-end" style="width:130px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($items->count() > 0): ?>
                    <?php foreach ($items as $l): ?>
                        <tr>
                            <td class="text-muted small fw-bold">#{{ $l->id }}</td>
                            <td>
                                <div class="small fw-semibold text-dark">{{ date('M d, Y', strtotime($l->created_at)) }}</div>
                                <div class="text-muted small" style="font-size:0.75rem">{{ date('h:i A', strtotime($l->created_at)) }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $l->name }}</div>
                                <?php if (!empty($l->subject)): ?>
                                    <span class="badge bg-light text-muted border small" style="font-size:0.7rem">{{ $l->subject }}</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="small d-flex align-items-center gap-2 mb-1">
                                    <a href="tel:{{ $l->phone }}" class="text-dark fw-semibold text-decoration-none">
                                        <i class="ri-phone-line text-muted"></i> {{ $l->phone }}
                                    </a>
                                    <a href="https://wa.me/91{{ preg_replace('/\D/', '', $l->phone) }}" target="_blank" class="btn btn-xs btn-outline-success py-0 px-1" style="font-size:10px" title="Chat on WhatsApp">
                                        <i class="ri-whatsapp-line"></i> WA
                                    </a>
                                </div>
                                <div class="small text-muted" style="font-size:0.78rem">
                                    <a href="mailto:{{ $l->email }}" class="text-muted text-decoration-none">
                                        <i class="ri-mail-line"></i> {{ $l->email }}
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="small text-secondary" style="max-width:240px;line-height:1.4">
                                    {{ \Illuminate\Support\Str::limit($l->message, 80) }}
                                </div>
                            </td>
                            <td>
                                <?php
                                $badgeClass = match ($l->status) {
                                    'new' => 'ds-badge-danger',
                                    'contacted' => 'ds-badge-info',
                                    'converted' => 'ds-badge-success',
                                    default => 'ds-badge-secondary',
                                };
                                ?>
                                <span class="ds-badge {{ $badgeClass }}">
                                    {{ ucfirst($l->status) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <a class="btn-action text-primary" href="{{ dura_admin('leads/' . $l->id) }}" title="Open Lead">
                                        <i class="ri-eye-line"></i>
                                    </a>
                                    <form class="d-inline m-0" method="post" action="{{ dura_admin('leads/' . $l->id . '/delete') }}" onsubmit="return confirm('Delete this lead record?')">
                                        {!! csrf_field() !!}
                                        <button type="submit" class="btn-action btn-action-danger text-danger" title="Delete">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="ri-contacts-book-line fs-1 d-block mb-2 text-secondary"></i>
                            <h6 class="fw-bold text-dark">No leads found</h6>
                            <p class="small text-muted mb-3">No contact enquiries matched your search or status filter.</p>
                            <?php if (request()->hasAny(['q', 'from', 'to', 'status'])): ?>
                                <a href="{{ dura_admin('leads') }}" class="btn btn-sm btn-outline-primary">
                                    <i class="ri-refresh-line me-1"></i> Clear all filters
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination Footer -->
    <?php if ($items->total() > 0): ?>
        <div class="ds-card-header bg-white border-top d-flex flex-column flex-sm-row align-items-center justify-content-between gap-3 py-3">
            <div class="small text-muted">
                Showing <span class="fw-semibold text-dark">{{ $items->firstItem() }}</span> to <span class="fw-semibold text-dark">{{ $items->lastItem() }}</span> of <span class="fw-semibold text-dark">{{ $items->total() }}</span> leads
            </div>
            <div>
                {{ $items->links() }}
            </div>
        </div>
    <?php endif; ?>
</div>
@endsection
