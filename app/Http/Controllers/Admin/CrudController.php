<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminResources as R;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CrudController extends Controller
{
    private function cfg(string $res, $row = null): array
    {
        return R::get($res, $row) + ['res' => $res];
    }

    public function index(Request $r, string $res)
    {
        $c = $this->cfg($res);
        $q = DB::table($c['table']);
        if ($s = trim((string) $r->query('q'))) {
            $q->where(function ($w) use ($c, $s) {
                foreach ($c['search'] as $col) {
                    $w->orWhere($col, 'like', "%$s%");
                }
            });
        }
        if ($r->has('status') && $r->query('status') !== '' && $r->query('status') !== null) {
            $q->where('status', (int) $r->query('status'));
        }
        if ($res === 'courses') {
            if ($r->filled('level')) {
                $q->where('level', $r->query('level'));
            }
            if ($r->has('popular') && $r->query('popular') !== '' && $r->query('popular') !== null) {
                $q->where('popular', (int) $r->query('popular'));
            }
        } elseif ($res === 'faqs') {
            if ($r->filled('page_key')) {
                $q->where('page_key', $r->query('page_key'));
            }
        } elseif ($res === 'blogs') {
            if ($r->filled('category')) {
                $q->where('category', $r->query('category'));
            }
        } elseif ($res === 'universities') {
            if ($r->filled('tag_theme')) {
                $q->where('tag_theme', $r->query('tag_theme'));
            }
        }

        $sort = $r->query('sort');
        $dir = strtolower($r->query('dir', 'desc')) === 'asc' ? 'asc' : 'desc';
        if ($sort && in_array($sort, ['id', 'title', 'name', 'sort_order', 'status', 'created_at', 'updated_at', 'published_at'])) {
            $q->orderBy($sort, $dir);
        } else {
            $q->orderByRaw($c['order']);
        }

        $perPage = in_array((int) $r->query('per_page'), [10, 15, 25, 50, 100], true) ? (int) $r->query('per_page') : 15;

        // Collect distinct filter options for UI
        $filterOptions = [];
        if ($res === 'courses') {
            $filterOptions['levels'] = DB::table('courses')->whereNotNull('level')->where('level', '!=', '')->distinct()->pluck('level')->all();
        } elseif ($res === 'blogs') {
            $filterOptions['categories'] = DB::table('blogs')->whereNotNull('category')->where('category', '!=', '')->distinct()->pluck('category')->all();
        } elseif ($res === 'universities') {
            $filterOptions['tag_themes'] = DB::table('universities')->whereNotNull('tag_theme')->where('tag_theme', '!=', '')->distinct()->pluck('tag_theme')->all();
        }

        $items = $q->paginate($perPage)->withQueryString();

        return view('admin.crud.index', [
            'c' => $c,
            'items' => $items,
            'filterOptions' => $filterOptions,
            'perPage' => $perPage,
        ]);
    }

    public function create(string $res)
    {
        $c = $this->cfg($res);
        abort_if(!empty($c['no_create']), 404);
        return view('admin.crud.form', ['c' => $c, 'row' => null, 'data' => $this->defaults($c), 'multi' => $this->multi($c, null)]);
    }

    public function edit(string $res, int $id)
    {
        $row = DB::table(R::get($res)['table'])->find($id);
        abort_if(!$row, 404);
        $c = $this->cfg($res, $row);
        return view('admin.crud.form', ['c' => $c, 'row' => $row, 'data' => $this->load($c, $row), 'multi' => $this->multi($c, $row)]);
    }

    public function store(Request $r, string $res)
    {
        return $this->save($r, $res, null);
    }

    public function update(Request $r, string $res, int $id)
    {
        return $this->save($r, $res, $id);
    }

    public function destroy(string $res, int $id)
    {
        $c = $this->cfg($res);
        abort_if(!empty($c['no_delete']), 404);
        if (!empty($c['custom_delete'])) {
            $pr = DB::table($c['table'])->find($id);
            abort_if(!$pr || empty((json_decode($pr->content ?? '', true) ?: [])['custom']), 404);
        }
        DB::table($c['table'])->where('id', $id)->delete();
        foreach ($c['fields'] as $f) {
            if ($f[2] === 'multi') {
                DB::table($f['pivot']['table'])->where($f['pivot']['self'], $id)->delete();
            }
        }
        return redirect(dura_admin($res))->with('ok', 'Deleted.');
    }

    // ------------------------------------------------------------------ helpers
    private function defaults(array $c): array
    {
        $d = [];
        foreach ($c['fields'] as $f) {
            $d[$f[0]] = $f['default'] ?? ($f[2] === 'json' ? '' : '');
        }
        return $d;
    }

    private function load(array $c, $row): array
    {
        $row = (array) $row;
        $content = json_decode($row['content'] ?? '', true) ?: [];
        $d = [];
        foreach ($c['fields'] as $f) {
            $n = $f[0];
            if (isset($f['json'])) {
                $d[$n] = $content[$f['json']] ?? '';
            } elseif ($f[2] === 'json') {
                $j = json_decode($row[$n] ?? '', true);
                $d[$n] = is_array($j) ? json_encode($j, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : '';
            } elseif ($f[2] === 'datetime') {
                $d[$n] = !empty($row[$n]) ? date('Y-m-d\TH:i', strtotime($row[$n])) : '';
            } elseif ($f[2] !== 'multi') {
                $d[$n] = $row[$n] ?? '';
            }
        }
        return $d;
    }

    private function multi(array $c, $row): array
    {
        $out = [];
        foreach ($c['fields'] as $f) {
            if ($f[2] !== 'multi') {
                continue;
            }
            $p = $f['pivot'];
            $out[$f[0]] = [
                'options' => DB::table($p['opt_table'])->orderBy($p['opt_label'])->pluck($p['opt_label'], 'id')->all(),
                'selected' => $row ? DB::table($p['table'])->where($p['self'], $row->id)->pluck($p['other'])->all() : [],
            ];
        }
        return $out;
    }

    private function upload(Request $r, string $field): ?string
    {
        $file = $r->file($field . '_file');
        if (!$file || !$file->isValid()) {
            return null;
        }
        $dir = 'uploads/' . date('Y/m');
        $name = Str::random(12) . '.' . strtolower($file->getClientOriginalExtension());
        $file->move(public_path($dir), $name);
        return "/$dir/$name";
    }

    private function save(Request $r, string $res, ?int $id)
    {
        $row = $id ? DB::table(R::get($res)['table'])->find($id) : null;
        abort_if($id && !$row, 404);
        $c = $this->cfg($res, $row);
        $rules = [];
        foreach ($c['fields'] as $f) {
            $x = [];
            if (!empty($f['req']) && $f[2] !== 'image' && !(($f['lock'] ?? false) && $row)) $x[] = 'required';
            if ($f[2] === 'image' && !empty($f['req'])) { $x = ['required_without:' . $f[0] . '_file']; }
            if ($f[2] === 'image') $rules[$f[0] . '_file'] = ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'];
            if ($f[2] === 'number') $x[] = 'nullable|numeric';
            if ($x) $rules[$f[0]] = implode('|', $x);
        }
        $r->validate($rules);

        $data = [];
        $content = $row ? (json_decode($row->content ?? '', true) ?: []) : [];
        $hasContent = false;
        foreach ($c['fields'] as $f) {
            [$n, , $t] = $f;
            if ($t === 'multi' || ($f['lock'] ?? false) && $row) {
                continue;
            }
            $v = $r->input($n);
            switch ($t) {
                case 'checkbox': $v = $r->boolean($n) ? 1 : 0; break;
                case 'number': $v = ($v === null || $v === '') ? 0 : (int) $v; break;
                case 'image': $v = $this->upload($r, $n) ?? trim((string) $v); break;
                case 'slug': $v = Str::slug((string) ($v ?: $r->input($f['from']))); break;
                case 'datetime': $v = $v ? date('Y-m-d H:i:s', strtotime($v)) : now(); break;
                case 'json':
                    $v = trim((string) $v);
                    if ($v !== '') {
                        json_decode($v);
                        if (json_last_error()) {
                            return back()->withInput()->withErrors([$n => 'Invalid JSON: ' . json_last_error_msg()]);
                        }
                        $v = json_encode(json_decode($v, true), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                    } else {
                        $v = null;
                    }
                    break;
                default: $v = $v === null ? null : trim((string) $v);
            }
            if (isset($f['json'])) {
                $content[$f['json']] = $v;
                $hasContent = true;
                continue;
            }
            $data[$n] = $v;
        }
        if ($res === 'pages' && !$row) {
            $content['custom'] = 1;
            $hasContent = true;
        }
        if ($hasContent) {
            $data['content'] = json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }
        if ($res === 'pages' && !$row) {
            $k = Str::slug((string) $r->input('page_key') ?: (string) $r->input('name'));
            $data['page_key'] = $k;
            if ($k === '' || in_array($k, R::RESERVED, true) || DB::table('pages')->where('page_key', $k)->exists()
                || DB::table('universities')->where('slug', $k)->exists() || DB::table('courses')->where('slug', $k)->exists()) {
                return back()->withInput()->withErrors(['page_key' => 'Slug is empty, reserved or already in use.']);
            }
        }
        // slug / key rules
        foreach (['slug', 'uid', 'cid'] as $k) {
            if (isset($data[$k]) || (!$row && in_array($k, array_column($c['fields'], 0)))) {
                $val = $data[$k] ?? Str::slug((string) $r->input($k));
                if ($k === 'cid' || $k === 'uid') {
                    $val = Str::slug((string) $r->input($k));
                    $data[$k] = $val;
                }
                if ($val === '') {
                    return back()->withInput()->withErrors([$k => 'This field is required.']);
                }
                if ($k === 'slug' && in_array($val, R::RESERVED, true) && $res !== 'blogs') {
                    return back()->withInput()->withErrors([$k => 'This slug is reserved.']);
                }
                if ($k === 'slug' && in_array($res, ['universities', 'courses'])) {
                    $other = $res === 'universities' ? 'courses' : 'universities';
                    if (DB::table($other)->where('slug', $val)->exists()) {
                        return back()->withInput()->withErrors([$k => 'This slug is already used by a ' . rtrim($other, 's') . '.']);
                    }
                }
                $dup = DB::table($c['table'])->where($k, $val)->when($id, fn($q) => $q->where('id', '!=', $id))->exists();
                if ($dup) {
                    return back()->withInput()->withErrors([$k => 'Already in use, choose another.']);
                }
            }
        }
        $data['updated_at'] = now();
        if ($row) {
            DB::table($c['table'])->where('id', $id)->update($data);
        } else {
            $data['created_at'] = now();
            $id = DB::table($c['table'])->insertGetId($data);
        }
        // pivots
        foreach ($c['fields'] as $f) {
            if ($f[2] !== 'multi') {
                continue;
            }
            $p = $f['pivot'];
            $sel = array_map('intval', (array) $r->input($f[0], []));
            DB::table($p['table'])->where($p['self'], $id)->whereNotIn($p['other'], $sel ?: [0])->delete();
            $have = DB::table($p['table'])->where($p['self'], $id)->pluck($p['other'])->all();
            foreach (array_diff($sel, $have) as $o) {
                DB::table($p['table'])->insert([$p['self'] => $id, $p['other'] => $o, $p['pos'] => 999]);
            }
        }
        dura_flush_cache();
        return redirect(dura_admin($res))->with('ok', 'Saved successfully.');
    }
}
