@extends('layouts.app')
@section('title', 'Panel Admin')

@section('content')
@php
    $warna = [
        'menunggu' => 'bg-amber-100 text-amber-800',
        'diterima' => 'bg-emerald-100 text-emerald-800',
        'cadangan' => 'bg-sky-100 text-sky-800',
        'ditolak' => 'bg-red-100 text-red-800',
    ];
@endphp

<h1 class='text-2xl font-bold mb-4'>Panel Admin</h1>

<div class='grid gap-3 grid-cols-2 lg:grid-cols-4 mb-6'>
    @foreach (['menunggu', 'diterima', 'cadangan', 'ditolak'] as $s)
        <a href='{{ route('admin.index', ['status' => $s]) }}' class='bg-white border rounded-xl p-4 hover:border-emerald-500'>
            <div class='text-xs uppercase text-slate-500'>{{ $s }}</div>
            <div class='text-2xl font-bold'>{{ $stat[$s] ?? 0 }}</div>
        </a>
    @endforeach
</div>

<div class='bg-white border rounded-xl p-4 mb-6'>
    <h2 class='font-semibold mb-2 text-sm'>Kuota terisi per jurusan</h2>
    <div class='grid gap-2 sm:grid-cols-2'>
        @foreach ($jurusans as $j)
            <div class='text-sm'>
                <div class='flex justify-between'><span>{{ $j->kode }}</span><span>{{ $j->diterima_count }} / {{ $j->kuota }}</span></div>
                <div class='h-2 bg-slate-100 rounded'><div class='h-2 bg-emerald-600 rounded' style='width: {{ min(100, $j->kuota ? round($j->diterima_count / $j->kuota * 100) : 0) }}%'></div></div>
            </div>
        @endforeach
    </div>
</div>

<form method='GET' class='flex flex-wrap gap-2 mb-4'>
    <input name='cari' value='{{ request('cari') }}' placeholder='Cari nama / nomor / NISN' class='rounded-lg border border-slate-300 px-3 py-2 text-sm flex-1 min-w-[200px]'>
    <select name='status' class='rounded-lg border border-slate-300 px-3 py-2 text-sm'>
        <option value=''>Semua status</option>
        @foreach (['menunggu', 'diterima', 'cadangan', 'ditolak'] as $s)
            <option value='{{ $s }}' @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <select name='jurusan' class='rounded-lg border border-slate-300 px-3 py-2 text-sm'>
        <option value=''>Semua jurusan</option>
        @foreach ($jurusans as $j)
            <option value='{{ $j->id }}' @selected((string) request('jurusan') === (string) $j->id)>{{ $j->kode }}</option>
        @endforeach
    </select>
    <button class='rounded-lg bg-emerald-700 text-white text-sm font-semibold px-4 py-2'>Filter</button>
</form>

<div class='bg-white border rounded-xl overflow-x-auto'>
    <table class='w-full text-sm'>
        <thead class='bg-slate-100 text-left text-xs uppercase text-slate-500'>
            <tr><th class='px-4 py-3'>Nomor</th><th class='px-4 py-3'>Nama</th><th class='px-4 py-3'>Jurusan</th><th class='px-4 py-3'>Status</th><th class='px-4 py-3'></th></tr>
        </thead>
        <tbody>
            @forelse ($pendaftars as $p)
                <tr class='border-t'>
                    <td class='px-4 py-3 font-mono'>{{ $p->nomor }}</td>
                    <td class='px-4 py-3'>{{ $p->nama }}</td>
                    <td class='px-4 py-3'>{{ $p->jurusan->kode }}</td>
                    <td class='px-4 py-3'><span class='text-xs font-semibold uppercase px-2 py-1 rounded-full {{ $warna[$p->status] ?? '' }}'>{{ $p->status }}</span></td>
                    <td class='px-4 py-3 text-right'><a href='{{ route('admin.show', $p) }}' class='text-emerald-700 hover:underline'>Detail</a></td>
                </tr>
            @empty
                <tr><td colspan='5' class='px-4 py-8 text-center text-slate-500'>Belum ada pendaftar.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class='mt-4'>{{ $pendaftars->links() }}</div>
@endsection
