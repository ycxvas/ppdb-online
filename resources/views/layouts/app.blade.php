<!doctype html>
<html lang='id'>
<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width,initial-scale=1'>
    <title>@yield('title', 'PPDB Online')</title>
    <script src='https://cdn.tailwindcss.com'></script>
</head>
<body class='bg-slate-50 text-slate-800 min-h-screen'>
    <header class='bg-emerald-700 text-white'>
        <div class='max-w-5xl mx-auto px-4 py-4 flex items-center justify-between'>
            <a href='{{ route('daftar') }}' class='font-bold text-lg'>PPDB Online</a>
            <nav class='flex items-center gap-5 text-sm'>
                <a href='{{ route('daftar') }}' class='hover:underline'>Daftar</a>
                <a href='{{ route('cek') }}' class='hover:underline'>Cek Status</a>
                @auth
                    <a href='{{ route('admin.index') }}' class='hover:underline'>Admin</a>
                    <form method='POST' action='{{ route('logout') }}'>@csrf<button class='hover:underline'>Keluar</button></form>
                @endauth
            </nav>
        </div>
    </header>

    <main class='max-w-5xl mx-auto px-4 py-8'>
        @if (session('ok'))
            <div class='mb-4 rounded-lg bg-emerald-100 text-emerald-800 px-4 py-3 text-sm'>{{ session('ok') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class='text-center text-xs text-slate-500 py-8'>Data pendaftar bersifat rahasia dan hanya dipakai untuk proses seleksi.</footer>
</body>
</html>
