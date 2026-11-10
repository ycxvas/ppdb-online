@extends('layouts.app')
@section('title', 'Pendaftaran Berhasil')

@section('content')
<div class='max-w-xl mx-auto bg-white border rounded-2xl p-8 text-center'>
    <div class='text-4xl mb-2'>&#10003;</div>
    <h1 class='text-2xl font-bold mb-2'>Pendaftaran berhasil</h1>
    <p class='text-slate-600 text-sm mb-6'>Simpan nomor pendaftaranmu. Kamu membutuhkannya bersama NISN untuk mengecek status.</p>
    <div class='text-3xl font-mono font-bold tracking-wide bg-emerald-50 text-emerald-800 rounded-xl py-4 mb-6'>{{ $nomor }}</div>
    <a href='{{ route('cek') }}' class='inline-block rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-semibold px-6 py-2.5'>Cek status pendaftaran</a>
</div>
@endsection
