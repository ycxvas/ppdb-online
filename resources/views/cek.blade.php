@extends('layouts.app')
@section('title', 'Cek Status')

@section('content')
@php
    $warna = [
        'menunggu' => 'bg-amber-100 text-amber-800',
        'diterima' => 'bg-emerald-100 text-emerald-800',
        'cadangan' => 'bg-sky-100 text-sky-800',
        'ditolak' => 'bg-red-100 text-red-800',
    ];
@endphp

<div class='max-w-xl mx-auto'>
    <h1 class='text-2xl font-bold mb-4'>Cek Status Pendaftaran</h1>

    <form method='POST' action='{{ route('cek.hasil') }}' class='bg-white border rounded-2xl p-6 grid gap-4 mb-6'>
        @csrf
        <div>
            <label class='block text-sm font-medium mb-1'>Nomor pendaftaran</label>
            <input name='nomor' value='{{ old('nomor') }}' placeholder='PPDB-2026-0001' class='w-full rounded-lg border border-slate-300 px-3 py-2 font-mono' required>
            @error('nomor')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
        </div>
        <div>
            <label class='block text-sm font-medium mb-1'>NISN</label>
            <input name='nisn' value='{{ old('nisn') }}' inputmode='numeric' maxlength='10' class='w-full rounded-lg border border-slate-300 px-3 py-2' required>
            @error('nisn')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
        </div>
        <button class='rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-semibold px-6 py-2.5'>Cek</button>
    </form>

    @if ($hasil)
        <div class='bg-white border rounded-2xl p-6'>
            <div class='flex items-center justify-between mb-4'>
                <div class='font-mono font-semibold'>{{ $hasil->nomor }}</div>
                <span class='text-xs font-semibold uppercase px-3 py-1 rounded-full {{ $warna[$hasil->status] ?? '' }}'>{{ $hasil->status }}</span>
            </div>
            <dl class='grid grid-cols-3 gap-y-2 text-sm'>
                <dt class='text-slate-500'>Nama</dt><dd class='col-span-2'>{{ $hasil->nama }}</dd>
                <dt class='text-slate-500'>Jurusan</dt><dd class='col-span-2'>{{ $hasil->jurusan->nama }}</dd>
                <dt class='text-slate-500'>Didaftarkan</dt><dd class='col-span-2'>{{ $hasil->created_at->translatedFormat('d F Y, H:i') }}</dd>
                @if ($hasil->catatan)
                    <dt class='text-slate-500'>Catatan panitia</dt><dd class='col-span-2'>{{ $hasil->catatan }}</dd>
                @endif
            </dl>
        </div>
    @endif
</div>
@endsection
