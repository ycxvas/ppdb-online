@extends('layouts.app')
@section('title', 'Login Admin')

@section('content')
<div class='max-w-sm mx-auto'>
    <h1 class='text-2xl font-bold mb-4'>Masuk Admin</h1>
    <form method='POST' action='{{ route('login') }}' class='bg-white border rounded-2xl p-6 grid gap-4'>
        @csrf
        <div>
            <label class='block text-sm font-medium mb-1'>Email</label>
            <input type='email' name='email' value='{{ old('email') }}' class='w-full rounded-lg border border-slate-300 px-3 py-2' required autofocus>
            @error('email')<p class='text-red-600 text-xs mt-1'>{{ $message }}</p>@enderror
        </div>
        <div>
            <label class='block text-sm font-medium mb-1'>Sandi</label>
            <input type='password' name='password' class='w-full rounded-lg border border-slate-300 px-3 py-2' required>
        </div>
        <button class='rounded-lg bg-emerald-700 hover:bg-emerald-800 text-white font-semibold px-6 py-2.5'>Masuk</button>
    </form>
</div>
@endsection
