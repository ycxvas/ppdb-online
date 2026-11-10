@extends('layouts.app')
@section('title', 'Detail Pendaftar')

@section('content')
<a href='{{ route('admin.index') }}' class='text-sm text-emerald-700 hover:underline'>&larr; Kembali</a>

<div class='grid gap-6 lg:grid-cols-3 mt-4'>
    <div class='lg:col-span-2 bg-white border rounded-2xl p-6'>
        <div class='font-mono font-semibold mb-4'>{{ $p->nomor }}</div>
        <dl class='grid grid-cols-3 gap-y-3 text-sm'>
            <dt class='text-slate-500'>Nama</dt><dd class='col-span-2'>{{ $p->nama }}</dd>
            <dt class='text-slate-500'>NISN</dt><dd class='col-span-2'>{{ $p->nisn }}</dd>
            <dt class='text-slate-500'>Jenis kelamin</dt><dd class='col-span-2'>{{ $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
            <dt class='text-slate-500'>TTL</dt><dd class='col-span-2'>{{ $p->tempat_lahir }}, {{ $p->tanggal_lahir->translatedFormat('d F Y') }}</dd>
            <dt class='text-slate-500'>Asal sekolah</dt><dd class='col-span-2'>{{ $p->asal_sekolah }}</dd>
            <dt class='text-slate-500'>Orang tua / wali</dt><dd class='col-span-2'>{{ $p->nama_wali }} ({{ $p->telepon_wali }})</dd>
            <dt class='text-slate-500'>Alamat</dt><dd class='col-span-2'>{{ $p->alamat }}</dd>
            <dt class='text-slate-500'>Jurusan</dt><dd class='col-span-2'>{{ $p->jurusan->nama }}</dd>
            <dt class='text-slate-500'>Dokumen</dt><dd class='col-span-2'><a href='{{ route('admin.dokumen', $p) }}' class='text-emerald-700 hover:underline'>Unduh dokumen</a></dd>
            <dt class='text-slate-500'>Didaftarkan</dt><dd class='col-span-2'>{{ $p->created_at->translatedFormat('d F Y, H:i') }}</dd>
        </dl>
    </div>

    <form method='POST' action='{{ route('admin.update', $p) }}' class='bg-white border rounded-2xl p-6 grid gap-4 content-start'>
        @csrf
        @method('PATCH')
        <h2 class='font-semibold'>Verifikasi</h2>
        <div>
            <label class='block text-sm font-medium mb-1'>Status</label>
            <select name='status' class='w-full rounded-lg border border-slate-300 px-3 py-2'>
                @foreach (['menunggu', 'diterima', 'cadangan', 'ditolak'] as $s)
                    <option value='{{ $s }}' @selected(old('status', $p->status) === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            @error('status')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
        </div>
        <div>
            <label class='block text-sm font-medium mb-1'>Catatan untuk pendaftar</label>
            <textarea name='catatan' rows='4' class='w-full rounded-lg border border-slate-300 px-3 py-2' maxlength='500'>{{ old('catatan', $p->catatan) }}</textarea>
            @error('catatan')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
        </div>
        <button class='rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-semibold px-6 py-2.5'>Simpan</button>
    </form>
</div>
@endsection
