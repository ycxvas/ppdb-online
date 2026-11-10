@extends('layouts.app')
@section('title', 'Pendaftaran PPDB')

@section('content')
<div class='mb-6'>
    <h1 class='text-2xl font-bold'>Formulir Pendaftaran</h1>
    <p class='text-slate-600 text-sm'>Isi data dengan benar. Simpan nomor pendaftaran yang kamu terima di akhir.</p>
</div>

<div class='grid gap-3 sm:grid-cols-2 lg:grid-cols-4 mb-8'>
    @foreach ($jurusans as $j)
        <div class='bg-white border rounded-xl p-4'>
            <div class='text-xs text-slate-500'>{{ $j->kode }}</div>
            <div class='font-semibold leading-snug'>{{ $j->nama }}</div>
            <div class='mt-2 text-sm'>Sisa kuota: <b>{{ $j->sisaKuota() }}</b> / {{ $j->kuota }}</div>
        </div>
    @endforeach
</div>

<form method='POST' action='{{ route('daftar.store') }}' enctype='multipart/form-data' class='bg-white border rounded-2xl p-6 grid gap-4 sm:grid-cols-2'>
    @csrf

    @php
        $input = 'w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500';
    @endphp

    <div class='sm:col-span-2'>
        <label class='block text-sm font-medium mb-1'>Nama lengkap</label>
        <input name='nama' value='{{ old('nama') }}' class='{{ $input }}' required maxlength='100'>
        @error('nama')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
    </div>

    <div>
        <label class='block text-sm font-medium mb-1'>NISN (10 digit)</label>
        <input name='nisn' value='{{ old('nisn') }}' class='{{ $input }}' inputmode='numeric' maxlength='10' required>
        @error('nisn')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
    </div>

    <div>
        <label class='block text-sm font-medium mb-1'>Jenis kelamin</label>
        <select name='jenis_kelamin' class='{{ $input }}' required>
            <option value=''>Pilih</option>
            <option value='L' @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
            <option value='P' @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
        </select>
        @error('jenis_kelamin')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
    </div>

    <div>
        <label class='block text-sm font-medium mb-1'>Tempat lahir</label>
        <input name='tempat_lahir' value='{{ old('tempat_lahir') }}' class='{{ $input }}' required>
        @error('tempat_lahir')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
    </div>

    <div>
        <label class='block text-sm font-medium mb-1'>Tanggal lahir</label>
        <input type='date' name='tanggal_lahir' value='{{ old('tanggal_lahir') }}' class='{{ $input }}' required>
        @error('tanggal_lahir')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
    </div>

    <div class='sm:col-span-2'>
        <label class='block text-sm font-medium mb-1'>Asal sekolah (SMP/MTs)</label>
        <input name='asal_sekolah' value='{{ old('asal_sekolah') }}' class='{{ $input }}' required>
        @error('asal_sekolah')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
    </div>

    <div>
        <label class='block text-sm font-medium mb-1'>Nama orang tua / wali</label>
        <input name='nama_wali' value='{{ old('nama_wali') }}' class='{{ $input }}' required>
        @error('nama_wali')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
    </div>

    <div>
        <label class='block text-sm font-medium mb-1'>No. telepon wali</label>
        <input name='telepon_wali' value='{{ old('telepon_wali') }}' class='{{ $input }}' inputmode='numeric' required>
        @error('telepon_wali')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
    </div>

    <div class='sm:col-span-2'>
        <label class='block text-sm font-medium mb-1'>Alamat</label>
        <textarea name='alamat' rows='3' class='{{ $input }}' required>{{ old('alamat') }}</textarea>
        @error('alamat')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
    </div>

    <div>
        <label class='block text-sm font-medium mb-1'>Jurusan pilihan</label>
        <select name='jurusan_id' class='{{ $input }}' required>
            <option value=''>Pilih jurusan</option>
            @foreach ($jurusans as $j)
                <option value='{{ $j->id }}' @selected((string) old('jurusan_id') === (string) $j->id)>{{ $j->nama }}</option>
            @endforeach
        </select>
        @error('jurusan_id')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
    </div>

    <div>
        <label class='block text-sm font-medium mb-1'>Dokumen (rapor/KK, PDF/JPG/PNG, maks 2 MB)</label>
        <input type='file' name='dokumen' accept='.pdf,.jpg,.jpeg,.png' class='block w-full text-sm' required>
        @error('dokumen')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
    </div>

    <div class='sm:col-span-2'>
        <button class='rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-semibold px-6 py-2.5'>Kirim pendaftaran</button>
    </div>
</form>
@endsection
