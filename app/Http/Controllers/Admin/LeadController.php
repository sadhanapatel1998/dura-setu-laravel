<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    private function query(Request $r)
    {
        $q = DB::table('leads')->orderByDesc('id');
        if ($r->filled('status')) {
            $q->where('status', $r->status);
        }
        if ($s = trim((string) $r->q)) {
            $q->where(fn($w) => $w->where('name', 'like', "%$s%")->orWhere('phone', 'like', "%$s%")->orWhere('email', 'like', "%$s%")->orWhere('message', 'like', "%$s%"));
        }
        if ($r->filled('from')) $q->whereDate('created_at', '>=', $r->from);
        if ($r->filled('to')) $q->whereDate('created_at', '<=', $r->to);
        return $q;
    }

    public function index(Request $r)
    {
        $perPage = in_array((int) $r->query('per_page'), [10, 15, 25, 50, 100], true) ? (int) $r->query('per_page') : 15;
        $statusCounts = [
            'all' => DB::table('leads')->count(),
            'new' => DB::table('leads')->where('status', 'new')->count(),
            'contacted' => DB::table('leads')->where('status', 'contacted')->count(),
            'converted' => DB::table('leads')->where('status', 'converted')->count(),
            'closed' => DB::table('leads')->where('status', 'closed')->count(),
        ];
        return view('admin.leads.index', [
            'items' => $this->query($r)->paginate($perPage)->withQueryString(),
            'statusCounts' => $statusCounts,
            'perPage' => $perPage,
        ]);
    }

    public function show(int $id)
    {
        $l = DB::table('leads')->find($id);
        abort_if(!$l, 404);
        return view('admin.leads.show', ['l' => $l]);
    }

    public function update(Request $r, int $id)
    {
        $r->validate(['status' => 'required|in:new,contacted,converted,closed']);
        DB::table('leads')->where('id', $id)->update(['status' => $r->status, 'notes' => $r->notes, 'updated_at' => now()]);
        return back()->with('ok', 'Lead updated.');
    }

    public function destroy(int $id)
    {
        DB::table('leads')->where('id', $id)->delete();
        return redirect(dura_admin('leads'))->with('ok', 'Lead deleted.');
    }

    public function export(Request $r)
    {
        $q = $this->query($r);
        return response()->streamDownload(function () use ($q) {
            $o = fopen('php://output', 'w');
            fputcsv($o, ['ID', 'Date', 'Name', 'Phone', 'Email', 'Subject', 'Message', 'Status', 'Page', 'IP']);
            foreach ($q->cursor() as $l) {
                fputcsv($o, [$l->id, $l->created_at, $l->name, $l->phone, $l->email, $l->subject, $l->message, $l->status, $l->source_url, $l->ip]);
            }
            fclose($o);
        }, 'leads-' . date('Y-m-d') . '.csv', ['Content-Type' => 'text/csv']);
    }
}
