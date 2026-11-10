<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PendaftarController extends Controller
{
    public function index(Request $request)
    {
        $query = Pendaftar::with('jurusan')->latest();

        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }
        if ($jurusan = $request->query('jurusan')) {
            $query->where('jurusan_id', $jurusan);
        }
        if ($cari = $request->query('cari')) {
            $query->where(function ($w) use ($cari) {
                $w->where('nama', 'like', "%{$cari}%")
                    ->orWhere('nomor', 'like', "%{$cari}%")
                    ->orWhere('nisn', 'like', "%{$cari}%");
            });
        }

        return view('admin.index', [
            'pendaftars' => $query->paginate(15)->withQueryString(),
            'stat' => Pendaftar::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total', 'status'),
            'jurusans' => Jurusan::withCount(['pendaftars as diterima_count' => fn ($q) => $q->where('status', 'diterima')])->orderBy('nama')->get(),
        ]);
    }

    public function show(Pendaftar $pendaftar)
    {
        $pendaftar->load('jurusan');

        return view('admin.show', ['p' => $pendaftar]);
    }

    public function update(Request $request, Pendaftar $pendaftar)
    {
        $data = $request->validate([
            'status' => 'required|in:'.implode(',', Pendaftar::STATUS),
            'catatan' => 'nullable|string|max:500',
        ]);

        // Transaksi + kunci baris jurusan: dua admin yang menerima pendaftar
        // secara bersamaan tidak bisa melewati batas kuota.
        return DB::transaction(function () use ($pendaftar, $data) {
            $jurusan = Jurusan::whereKey($pendaftar->jurusan_id)->lockForUpdate()->firstOrFail();
            $pendaftar->refresh();

            if ($data['status'] === 'diterima' && $pendaftar->status !== 'diterima') {
                $terisi = Pendaftar::where('jurusan_id', $jurusan->id)->where('status', 'diterima')->count();
                if ($terisi >= $jurusan->kuota) {
                    return back()->withErrors(['status' => 'Kuota jurusan sudah penuh. Pilih status cadangan.']);
                }
            }

            $pendaftar->update($data);

            return back()->with('ok', 'Status pendaftar diperbarui.');
        });
    }

    public function dokumen(Pendaftar $pendaftar)
    {
        abort_unless(Storage::exists($pendaftar->dokumen), 404);

        $ext = pathinfo($pendaftar->dokumen, PATHINFO_EXTENSION);

        return Storage::download($pendaftar->dokumen, $pendaftar->nomor.'.'.$ext);
    }
}
