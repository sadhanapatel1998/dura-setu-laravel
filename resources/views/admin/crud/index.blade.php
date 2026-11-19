@extends('admin.layout', ['title' => $c['title']])

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h3 class="fw-bold mb-1 d-flex align-items-center gap-2">
            {{ $c['title'] }}
            <span class="badge bg-light text-dark border fs-6 fw-normal rounded-pill">
                {{ $items->total() }} total
            </span>
        </h3>
        <p class="text-muted small mb-0">Manage and organize all {{ strtolower($c['title']) }} published on DuraSetu.</p>
    </div>
    <div>
        <?php if (empty($c['no_create'])): ?>
            <a class="btn btn-primary d-inline-flex align-items-center gap-2 shadow-sm" href="{{ dura_admin($c['res'] . '/create') }}">
                <i class="ri-add-circle-line fs-5"></i>
                <span>Add {{ rtrim($c['title'], 's') }}</span>
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Filter Card -->
<div class="filter-card">
    <form method="get" action="{{ dura_admin($c['res']) }}" class="row g-2 align-items-center">
        <!-- Search -->
        <div class="col-12 col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0 text-muted">
                    <i class="ri-search-line"></i>
                </span>
                <input type="text" class="form-control border-start-0" name="q" value="{{ request('q') }}" placeholder="Search by {{ implode(', ', $c['search'] ?? ['title']) }}...">
            </div>
        </div>

        <!-- Status Filter (for resources that have status) -->
        <?php if ($c['res'] !== 'pages'): ?>
            <div class="col-6 col-md-2">
                <select class="form-select form-select-sm" name="status">
                    <option value="">All Statuses</option>
                    <option value="1" <?= request('status') === '1' ? 'selected' : '' ?>>Active only</option>
                    <option value="0" <?= request('status') === '0' ? 'selected' : '' ?>>Inactive only</option>
                </select>
            </div>
        <?php endif; ?>

        <!-- Resource-Specific Filters -->
        <?php if ($c['res'] === 'courses'): ?>
            <div class="col-6 col-md-2">
                <select class="form-select form-select-sm" name="level">
                    <option value="">All Levels</option>
                    <?php foreach ($filterOptions['levels'] ?? [] as $lvl): ?>
                        <option value="{{ $lvl }}" <?= request('level') === $lvl ? 'selected' : '' ?>>{{ $lvl }}</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select class="form-select form-select-sm" name="popular">
                    <option value="">Popular & Regular</option>
                    <option value="1" <?= request('popular') === '1' ? 'selected' : '' ?>>Popular only</option>
                </select>
            </div>
        <?php elseif ($c['res'] === 'faqs'): ?>
            <div class="col-6 col-md-2">
                <select class="form-select form-select-sm" name="page_key">
                    <option value="">All Pages</option>
                    <option value="home" <?= request('page_key') === 'home' ? 'selected' : '' ?>>Home Page</option>
                    <option value="about" <?= request('page_key') === 'about' ? 'selected' : '' ?>>About Page</option>
                </select>
            </div>
        <?php elseif ($c['res'] === 'blogs' && !empty($filterOptions['categories'])): ?>
            <div class="col-6 col-md-2">
                <select class="form-select form-select-sm" name="category">
                    <option value="">All Categories</option>
                    <?php foreach ($filterOptions['categories'] as $cat): ?>
                        <option value="{{ $cat }}" <?= request('category') === $cat ? 'selected' : '' ?>>{{ $cat }}</option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php elseif ($c['res'] === 'universities' && !empty($filterOptions['tag_themes'])): ?>
            <div class="col-6 col-md-2">
                <select class="form-select form-select-sm" name="tag_theme">
                    <option value="">All Themes</option>
                    <?php foreach ($filterOptions['tag_themes'] as $theme): ?>
                        <option value="{{ $theme }}" <?= request('tag_theme') === $theme ? 'selected' : '' ?>>{{ ucfirst($theme) }}</option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

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

        <!-- Action Buttons -->
        <div class="col-12 col-md-auto ms-auto d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
                <i class="ri-filter-3-line"></i> Filter
            </button>
            <?php if (request()->hasAny(['q', 'status', 'level', 'popular', 'page_key', 'category', 'tag_theme'])): ?>
                <a href="{{ dura_admin($c['res']) }}" class="btn btn-outline-secondary btn-sm" title="Clear Filters">
                    <i class="ri-refresh-line"></i> Reset
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Data Table Card -->
<div class="ds-card">
    <div class="table-responsive">
        <table class="table ds-table mb-0">
            <thead>
                <tr>
                    <th style="width:50px">#</th>
                    <?php foreach ($c['cols'] as $k => $l): ?>
                        <th>{{ $l }}</th>
                    <?php endforeach; ?>
                    <th class="text-end" style="width:160px">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($items->count() > 0): ?>
                    <?php foreach ($items as $idx => $it): ?>
                        <tr>
                            <td class="text-muted small">{{ $items->firstItem() + $idx }}</td>
                            <?php foreach ($c['cols'] as $k => $l): $v = $it->$k ?? ''; ?>
                                <td>
                                    <?php if ($k === 'image' || $k === 'mobile_image'): ?>
                                        <?php if ($v): ?>
                                            <img class="table-thumb" src="{{ dura_path($v) }}" alt="" onerror="this.style.display='none'">
                                        <?php else: ?>
                                            <span class="text-muted small">—</span>
                                        <?php endif; ?>
                                    <?php elseif ($k === 'logo'): ?>
                                        <?php if ($v): ?>
                                            <img class="table-logo" src="{{ dura_path($v) }}" alt="" onerror="this.style.display='none'">
                                        <?php else: ?>
                                            <span class="text-muted small">—</span>
                                        <?php endif; ?>
                                    <?php elseif ($k === 'status'): ?>
                                        <?php if ($v): ?>
                                            <span class="ds-badge ds-badge-success"><i class="ri-checkbox-circle-fill"></i> Active</span>
                                        <?php else: ?>
                                            <span class="ds-badge ds-badge-secondary"><i class="ri-close-circle-line"></i> Inactive</span>
                                        <?php endif; ?>
                                    <?php elseif ($k === 'popular'): ?>
                                        <?php if ($v): ?>
                                            <span class="ds-badge ds-badge-warning"><i class="ri-star-fill"></i> Popular</span>
                                        <?php else: ?>
                                            <span class="text-muted small">Regular</span>
                                        <?php endif; ?>
                                    <?php elseif ($k === 'rating'): ?>
                                        <div class="text-warning small">
                                            <?php for ($s = 1; $s <= 5; $s++): ?>
                                                <i class="ri-star-<?= $s <= (int)$v ? 'fill' : 'line' ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    <?php elseif ($k === 'published_at'): ?>
                                        <span class="small text-muted">
                                            {{ $v ? date('M d, Y', strtotime($v)) : '—' }}
                                        </span>
                                    <?php elseif ($k === 'title' || $k === 'name'): ?>
                                        <a href="{{ dura_admin($c['res'] . '/' . $it->id . '/edit') }}" class="fw-semibold text-dark text-decoration-none">
                                            {{ $v }}
                                        </a>
                                        <?php if (isset($it->slug)): ?>
                                            <div class="text-muted small" style="font-size:0.75rem">/{{ $it->slug }}</div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="small text-secondary">{{ \Illuminate\Support\Str::limit(strip_tags((string) $v), 60) }}</span>
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                            <td class="text-end">
                                <div class="d-inline-flex gap-1">
                                    <?php if (!empty($c['view']) && (!empty($it->slug) || (!empty($it->page_key) && str_contains((string) ($it->content ?? ''), '"custom"')))): ?>
                                        <a class="btn-action" target="_blank" href="{{ str_replace('{slug}', $it->slug ?? $it->page_key ?? '', $c['view']) }}" title="View on site">
                                            <i class="ri-external-link-line"></i>
                                        </a>
                                    <?php endif; ?>
                                    <a class="btn-action text-primary" href="{{ dura_admin($c['res'] . '/' . $it->id . '/edit') }}" title="Edit">
                                        <i class="ri-edit-line"></i>
                                    </a>
                                    <?php if (empty($c['no_delete']) && (empty($c['custom_delete']) || str_contains((string) ($it->content ?? ''), '"custom"'))): ?>
                                        <form class="d-inline m-0" method="post" action="{{ dura_admin($c['res'] . '/' . $it->id . '/delete') }}" onsubmit="return confirm('Are you sure you want to delete this record? This action cannot be undone.')">
                                            {!! csrf_field() !!}
                                            <button type="submit" class="btn-action btn-action-danger text-danger" title="Delete">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= count($c['cols']) + 2 ?>" class="text-center py-5 text-muted">
                            <i class="ri-search-line fs-1 d-block mb-2 text-secondary"></i>
                            <h6 class="fw-bold text-dark">No records found</h6>
                            <p class="small text-muted mb-3">No {{ strtolower($c['title']) }} matched your search and filter criteria.</p>
                            <?php if (request()->hasAny(['q', 'status', 'level', 'popular', 'page_key', 'category', 'tag_theme'])): ?>
                                <a href="{{ dura_admin($c['res']) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="ri-refresh-line me-1"></i> Clear all filters
                                </a>
                            <?php elseif (empty($c['no_create'])): ?>
                                <a href="{{ dura_admin($c['res'] . '/create') }}" class="btn btn-sm btn-primary">
                                    <i class="ri-add-line me-1"></i> Add new {{ rtrim($c['title'], 's') }}
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
                Showing <span class="fw-semibold text-dark">{{ $items->firstItem() }}</span> to <span class="fw-semibold text-dark">{{ $items->lastItem() }}</span> of <span class="fw-semibold text-dark">{{ $items->total() }}</span> entries
            </div>
            <div>
                {{ $items->links() }}
            </div>
        </div>
    <?php endif; ?>
</div>
@endsection
