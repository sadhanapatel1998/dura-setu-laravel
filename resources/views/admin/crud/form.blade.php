@extends('admin.layout', ['title' => ($row ? 'Edit ' : 'Add ') . rtrim($c['title'], 's')])
@section('content')
<?php
$data = $data ?? [];
$multi = $multi ?? [];
$tabs = [];
foreach ($c['fields'] as $f) {
    $tabs[$f['tab'] ?? 'Main Details'][] = $f;
}
$first = array_key_first($tabs);
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <div class="mb-1">
            <a href="{{ dura_admin($c['res']) }}" class="text-decoration-none small text-muted d-inline-flex align-items-center gap-1">
                <i class="ri-arrow-left-line"></i> Back to {{ $c['title'] }}
            </a>
        </div>
        <h3 class="fw-bold mb-0">
            {{ $row ? 'Edit ' . rtrim($c['title'], 's') : 'Create New ' . rtrim($c['title'], 's') }}
            <?php if ($row && !empty($row->name)): ?>
                <span class="text-muted fw-normal fs-5">· {{ $row->name }}</span>
            <?php elseif ($row && !empty($row->title)): ?>
                <span class="text-muted fw-normal fs-5">· {{ $row->title }}</span>
            <?php endif; ?>
        </h3>
    </div>
    <div class="d-flex gap-2">
        <?php if ($row && !empty($c['view']) && !empty($row->slug)): ?>
            <a class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1" target="_blank" href="{{ str_replace('{slug}', $row->slug ?? '', $c['view']) }}">
                <i class="ri-external-link-line"></i> View Page
            </a>
        <?php endif; ?>
        <a class="btn btn-light btn-sm border" href="{{ dura_admin($c['res']) }}">Cancel</a>
    </div>
</div>

<form method="post" enctype="multipart/form-data" action="{{ dura_admin($c['res'] . ($row ? '/' . $row->id : '')) }}">
    {!! csrf_field() !!}

    <div class="ds-card">
        <!-- Tabs Header -->
        <div class="ds-card-header p-2 px-3">
            <ul class="nav nav-pills gap-1">
                <?php $i = 0; foreach ($tabs as $t => $fs): $i++; ?>
                    <?php
                    $tabIcon = match ($t) {
                        'SEO' => 'ri-search-eye-line',
                        'Advanced data' => 'ri-code-box-line',
                        'About section' => 'ri-information-line',
                        default => 'ri-edit-line',
                    };
                    ?>
                    <li class="nav-item">
                        <button type="button" class="nav-link py-2 px-3 small fw-semibold <?= $t === $first ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tab_{{ $i }}">
                            <i class="{{ $tabIcon }} me-1"></i> {{ $t }}
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Tabs Content Body -->
        <div class="ds-card-body p-4">
            <div class="tab-content">
                <?php $i = 0; foreach ($tabs as $t => $fs): $i++; ?>
                    <div class="tab-pane fade <?= $t === $first ? 'show active' : '' ?>" id="tab_{{ $i }}">
                        <div class="row g-3">
                            <?php foreach ($fs as $f): ?>
                                <?php
                                [$n, $label, $type] = $f;
                                $val = old($n, $data[$n] ?? '');
                                $locked = !empty($f['lock']) && $row;
                                $isFullWidth = in_array($type, ['textarea', 'json', 'multi']) || !empty($f['full']);
                                $colClass = $isFullWidth ? 'col-12' : (in_array($type, ['checkbox', 'number']) ? 'col-md-6 col-lg-4' : 'col-md-6');
                                ?>
                                <div class="{{ $colClass }}">
                                    <div class="mb-1 d-flex align-items-center justify-content-between">
                                        <label class="form-label small fw-bold text-dark mb-0" for="field_{{ $n }}">
                                            {{ $label }}
                                            <?php if (!empty($f['req'])): ?>
                                                <span class="text-danger">*</span>
                                            <?php endif; ?>
                                        </label>
                                        <?php if ($locked): ?>
                                            <span class="badge bg-light text-muted border" style="font-size:0.65rem">Locked</span>
                                        <?php endif; ?>
                                    </div>

                                    <?php if ($type === 'textarea' || $type === 'json'): ?>
                                        <textarea class="form-control form-control-sm <?= $type === 'json' ? 'font-monospace' : '' ?> <?= !empty($f['editor']) ? 'js-rich' : '' ?>" id="field_{{ $n }}" name="{{ $n }}" rows="<?= $f['rows'] ?? 4 ?>" <?= $locked ? 'readonly' : '' ?> style="<?= $type === 'json' ? 'font-size:12px;background:#f8fafc;' : '' ?>">{{ $val }}</textarea>

                                    <?php elseif ($type === 'select'): ?>
                                        <select class="form-select form-select-sm" id="field_{{ $n }}" name="{{ $n }}">
                                            <?php foreach ($f['options'] as $ov => $ol): ?>
                                                <option value="{{ $ov }}" <?= (string) $val === (string) $ov ? 'selected' : '' ?>>{{ $ol }}</option>
                                            <?php endforeach; ?>
                                        </select>

                                    <?php elseif ($type === 'checkbox'): ?>
                                        <div class="form-check form-switch p-0 pt-1 d-flex align-items-center gap-2">
                                            <input type="checkbox" class="form-check-input m-0 ms-1" id="field_{{ $n }}" name="{{ $n }}" value="1" <?= $val ? 'checked' : '' ?>>
                                            <label class="form-check-label small text-muted" for="field_{{ $n }}">Enable / Active</label>
                                        </div>

                                    <?php elseif ($type === 'number'): ?>
                                        <input type="number" class="form-control form-control-sm" id="field_{{ $n }}" name="{{ $n }}" value="{{ $val }}" <?= $locked ? 'readonly' : '' ?>>

                                    <?php elseif ($type === 'datetime'): ?>
                                        <input type="datetime-local" class="form-control form-control-sm" id="field_{{ $n }}" name="{{ $n }}" value="{{ $val ?: date('Y-m-d\TH:i') }}">

                                    <?php elseif ($type === 'image'): ?>
                                        <div class="border rounded-3 p-2 bg-light">
                                            <div class="d-flex gap-3 align-items-center mb-2">
                                                <?php if ($val): ?>
                                                    <img class="table-thumb" style="width:54px;height:54px" src="{{ dura_path($val) }}" alt="Preview" onerror="this.src='{{ asset('assets/img/icons/graduation-cap.svg') }}'">
                                                <?php else: ?>
                                                    <div class="table-thumb d-flex align-items-center justify-content-center text-muted" style="width:54px;height:54px">
                                                        <i class="ri-image-line fs-4"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="flex-grow-1">
                                                    <input type="file" class="form-control form-control-sm mb-1" name="{{ $n }}_file" accept="image/*">
                                                    <input type="text" class="form-control form-control-sm text-muted font-monospace" name="{{ $n }}" value="{{ $val }}" placeholder="Or paste existing URL: /assets/img/..." style="font-size:11px">
                                                </div>
                                            </div>
                                        </div>

                                    <?php elseif ($type === 'multi'): ?>
                                        <?php $m = $multi[$n] ?? ['options' => [], 'selected' => []]; ?>
                                        <div class="border rounded-3 p-3 bg-light">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="small fw-semibold text-muted">Select applicable options:</span>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2" style="font-size:11px" onclick="toggleAllCheckboxes('{{ $n }}', true)">Check all</button>
                                                    <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-2" style="font-size:11px" onclick="toggleAllCheckboxes('{{ $n }}', false)">Uncheck all</button>
                                                </div>
                                            </div>
                                            <div class="row g-2" style="max-height:280px;overflow-y:auto">
                                                <?php foreach ($m['options'] as $oid => $ol): ?>
                                                    <div class="col-12 col-sm-6 col-md-4">
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input multi-check-{{ $n }}" id="chk_{{ $n }}_{{ $oid }}" name="{{ $n }}[]" value="{{ $oid }}" <?= in_array($oid, old($n, $m['selected'])) ? 'checked' : '' ?>>
                                                            <label class="form-check-label small" for="chk_{{ $n }}_{{ $oid }}">{{ $ol }}</label>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>

                                    <?php else: ?>
                                        <input type="text" class="form-control form-control-sm" id="field_{{ $n }}" name="{{ $n }}" value="{{ $val }}" <?= $locked ? 'readonly' : '' ?> <?= $type === 'slug' ? 'placeholder="auto-generated from title if blank"' : '' ?>>
                                    <?php endif; ?>

                                    <?php if (!empty($f['help'])): ?>
                                        <div class="form-text small text-muted" style="font-size:0.75rem">{{ $f['help'] }}</div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sticky Footer Action Bar -->
        <div class="ds-card-header bg-white border-top p-3 d-flex justify-content-between align-items-center">
            <a class="btn btn-light btn-sm border" href="{{ dura_admin($c['res']) }}">Cancel</a>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm px-4 d-inline-flex align-items-center gap-1 shadow-sm">
                    <i class="ri-save-3-line"></i> Save {{ rtrim($c['title'], 's') }}
                </button>
            </div>
        </div>
    </div>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
const ASSET_BASE = '{{ rtrim(asset('/'), '/') }}';
if (window.tinymce && document.querySelector('.js-rich')) {
    tinymce.init({
        selector: 'textarea.js-rich', height: 520, branding: false, promotion: false, menubar: 'edit insert format table tools',
        plugins: 'lists link image table code fullscreen media autolink charmap searchreplace wordcount',
        toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright | bullist numlist outdent indent | link image media table | blockquote hr | removeformat code fullscreen',
        relative_urls: false, convert_urls: true, image_advtab: true, image_caption: true, link_default_target: '_blank',
        automatic_uploads: true, file_picker_types: 'image',
        // /uploads/.. , /assets/.. , uploads/.. -> site asset URL (this site serves them from /public/)
        urlconverter_callback: (url) => /^\/?(assets|uploads|storage)\//i.test(url) ? ASSET_BASE + '/' + url.replace(/^\//, '') : url,
        images_upload_handler: (blob) => new Promise((ok, fail) => {
            const fd = new FormData(); fd.append('file', blob.blob(), blob.filename());
            fetch('{{ dura_admin('editor-upload') }}', {method: 'POST', body: fd, credentials: 'same-origin', headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest'}})
                .then(r => r.json().then(j => ({r, j})))
                .then(({r, j}) => j.location ? ok(j.location) : fail(j.error || j.message || ('Upload failed (' + r.status + ')')))
                .catch(() => fail('Upload failed - check login/session or file size (max 4 MB)'));
        })
    });
}
</script>
<script>
function toggleAllCheckboxes(name, check) {
    document.querySelectorAll('.multi-check-' + name).forEach(el => el.checked = check);
}
</script>
@endsection