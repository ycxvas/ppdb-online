<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PendaftaranController extends Controller
{
    public function create()
    {
        $jurusans = Jurusan::orderBy('nama')->get();

        return view('daftar', compact('jurusans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:100',
            'nisn' => 'required|digits:10|unique:pendaftars,nisn',
            'tempat_lahir' => 'required|string|max:60',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'asal_sekolah' => 'required|string|max:100',
            'nama_wali' => 'required|string|max:100',
            'telepon_wali' => 'required|digits_between:8,15',
            'alamat' => 'required|string|max:300',
            'jurusan_id' => 'required|exists:jurusans,id',
            'dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'nisn.unique' => 'NISN ini sudah terdaftar.',
            'nisn.digits' => 'NISN harus 10 digit angka.',
            'dokumen.max' => 'Ukuran dokumen maksimal 2 MB.',
        ]);

        $data['dokumen'] = $request->file('dokumen')->store('dokumen');

        $pendaftar = DB::transaction(function () use ($data) {
            $p = Pendaftar::create($data + [
                'nomor' => 'TMP-'.Str::random(10),
                'status' => 'menunggu',
            ]);
            $p->update(['nomor' => sprintf('PPDB-%s-%04d', now()->format('Y'), $p->id)]);

            return $p;
        });

        return redirect()->route('sukses')->with('nomor', $pendaftar->nomor);
    }

    public function sukses()
    {
        if (! session('nomor')) {
            return redirect()->route('daftar');
        }

        return view('sukses', ['nomor' => session('nomor')]);
    }

    public function cekForm()
    {
        return view('cek', ['hasil' => null]);
    }

    public function cekHasil(Request $request)
    {
        $data = $request->validate([
            'nomor' => 'required|string|max:30',
            'nisn' => 'required|digits:10',
        ]);

        $hasil = Pendaftar::with('jurusan')
            ->where('nomor', strtoupper(trim($data['nomor'])))
            ->where('nisn', $data['nisn'])
            ->first();

        if (! $hasil) {
            return back()->withInput()->withErrors(['nomor' => 'Nomor pendaftaran atau NISN tidak cocok.']);
        }

        return view('cek', ['hasil' => $hasil]);
    }
}
