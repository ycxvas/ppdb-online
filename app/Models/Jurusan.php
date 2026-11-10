<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    protected $fillable = ['nama', 'kode', 'kuota'];

    public function pendaftars(): HasMany
    {
        return $this->hasMany(Pendaftar::class);
    }

    public function sisaKuota(): int
    {
        $terisi = $this->pendaftars()->where('status', 'diterima')->count();

        return max(0, $this->kuota - $terisi);
    }
}
