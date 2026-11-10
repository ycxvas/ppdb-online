<?php

namespace Database\Seeders;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Jurusan contoh. Ganti sesuai sekolahmu.
        $daftar = [
            ['nama' => 'Rekayasa Perangkat Lunak', 'kode' => 'RPL', 'kuota' => 36],
            ['nama' => 'Teknik Komputer dan Jaringan', 'kode' => 'TKJ', 'kuota' => 36],
            ['nama' => 'Akuntansi', 'kode' => 'AKL', 'kuota' => 36],
            ['nama' => 'Desain Komunikasi Visual', 'kode' => 'DKV', 'kuota' => 30],
        ];

        foreach ($daftar as $j) {
            Jurusan::updateOrCreate(['kode' => $j['kode']], $j);
        }

        // Akun admin dari .env (ADMIN_NAMA, ADMIN_EMAIL, ADMIN_PASSWORD).
        $email = env('ADMIN_EMAIL', 'admin@contoh.sch.id');
        $sandi = env('ADMIN_PASSWORD') ?: Str::random(14);

        User::updateOrCreate(
            ['email' => $email],
            ['name' => env('ADMIN_NAMA', 'Admin PPDB'), 'password' => Hash::make($sandi)]
        );

        if (! env('ADMIN_PASSWORD')) {
            $this->command->info("Admin dibuat. Email: {$email} | Sandi: {$sandi}");
        }
    }
}
