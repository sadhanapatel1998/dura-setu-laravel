@extends('admin.layout', ['title' => 'Enquiry #' . $l->id])

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <div class="mb-1">
            <a href="{{ dura_admin('leads') }}" class="text-decoration-none small text-muted d-inline-flex align-items-center gap-1">
                <i class="ri-arrow-left-line"></i> Back to All Leads
            </a>
        </div>
        <h3 class="fw-bold mb-0 d-flex align-items-center gap-2">
            Enquiry #{{ $l->id }}
            <?php
            $badgeClass = match ($l->status) {
                'new' => 'ds-badge-danger',
                'contacted' => 'ds-badge-info',
                'converted' => 'ds-badge-success',
                default => 'ds-badge-secondary',
            };
            ?>
            <span class="ds-badge {{ $badgeClass }} fs-6 fw-normal">
                {{ ucfirst($l->status) }}
            </span>
        </h3>
    </div>
    <div class="d-flex gap-2">
        <a href="tel:{{ $l->phone }}" class="btn btn-outline-primary btn-sm d-inline-flex align-items-center gap-1">
            <i class="ri-phone-line"></i> Call Student
        </a>
        <a href="https://wa.me/91{{ preg_replace('/\D/', '', $l->phone) }}?text=Hello%20{{ rawurlencode($l->name) }},%20thank%20you%20for%20contacting%20DuraSetu." target="_blank" class="btn btn-success btn-sm d-inline-flex align-items-center gap-1">
            <i class="ri-whatsapp-line"></i> Chat on WhatsApp
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Lead Info & Message -->
    <div class="col-lg-7">
        <div class="ds-card mb-4">
            <div class="ds-card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="ri-user-line text-primary"></i>
                    <h5 class="fw-bold mb-0">Student Profile & Submission</h5>
                </div>
                <span class="small text-muted">{{ date('M d, Y h:i A', strtotime($l->created_at)) }}</span>
            </div>
            <div class="p-4">
                <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold fs-4" style="width:56px;height:56px">
                        {{ strtoupper(substr($l->name, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ $l->name }}</h4>
                        <?php if (!empty($l->subject)): ?>
                            <span class="badge bg-light text-primary border mt-1">{{ $l->subject }}</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-sm-6">
                        <label class="small text-muted fw-bold text-uppercase d-block mb-1">Phone Number</label>
                        <div class="fw-semibold text-dark">
                            <a href="tel:{{ $l->phone }}" class="text-decoration-none text-dark">
                                <i class="ri-phone-fill text-primary me-1"></i> {{ $l->phone }}
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="small text-muted fw-bold text-uppercase d-block mb-1">Email Address</label>
                        <div class="fw-semibold text-dark">
                            <a href="mailto:{{ $l->email }}" class="text-decoration-none text-dark">
                                <i class="ri-mail-fill text-danger me-1"></i> {{ $l->email }}
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="small text-muted fw-bold text-uppercase d-block mb-1">Source Page URL</label>
                        <div class="small text-muted text-truncate">
                            <a href="{{ $l->source_url }}" target="_blank" class="text-decoration-none text-secondary">
                                <i class="ri-link text-muted me-1"></i> {{ $l->source_url ?: '/' }}
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label class="small text-muted fw-bold text-uppercase d-block mb-1">Client IP Address</label>
                        <div class="small text-muted font-monospace">
                            <i class="ri-map-pin-line text-muted me-1"></i> {{ $l->ip ?: '127.0.0.1' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Message Card -->
        <div class="ds-card">
            <div class="ds-card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="ri-chat-1-line text-success"></i>
                    <h5 class="fw-bold mb-0">Enquiry Message</h5>
                </div>
            </div>
            <div class="p-4">
                <div class="p-3 rounded-3 bg-light border" style="line-height:1.7;font-size:0.95rem">
                    {!! nl2br(e($l->message)) !!}
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Status & Follow-up Notes -->
    <div class="col-lg-5">
        <div class="ds-card mb-4">
            <div class="ds-card-header">
                <div class="d-flex align-items-center gap-2">
                    <i class="ri-edit-2-line text-primary"></i>
                    <h5 class="fw-bold mb-0">Manage Lead Status</h5>
                </div>
            </div>
            <div class="p-4">
                <form method="post" action="{{ dura_admin('leads/' . $l->id) }}">
                    {!! csrf_field() !!}

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Enquiry Status</label>
                        <select class="form-select" name="status">
                            <?php foreach (['new' => 'New (Unread / Pending)', 'contacted' => 'Contacted (Follow-up in progress)', 'converted' => 'Converted (Admission enrolled)', 'closed' => 'Closed (Not interested / Completed)'] as $s => $label): ?>
                                <option value="{{ $s }}" <?= $l->status === $s ? 'selected' : '' ?>>{{ $label }}</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark">Counsellor Internal Notes</label>
                        <textarea class="form-control" name="notes" rows="6" placeholder="Log student preference, call records, fee discussion or next scheduled follow-up...">{{ $l->notes }}</textarea>
                        <div class="form-text small text-muted">Notes are visible to admins and counsellors only.</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
                        <i class="ri-check-line"></i> Save Lead Update
                    </button>
                </form>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="ds-card border-danger border-opacity-25">
            <div class="p-3 d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-bold small text-danger">Delete Enquiry</div>
                    <div class="text-muted" style="font-size:0.75rem">Permanently remove this lead from the database.</div>
                </div>
                <form method="post" action="{{ dura_admin('leads/' . $l->id . '/delete') }}" onsubmit="return confirm('Delete this enquiry permanently?')">
                    {!! csrf_field() !!}
                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete Lead</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
