<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pendaftar extends Model
{
    public const STATUS = ['menunggu', 'diterima', 'cadangan', 'ditolak'];

    protected $fillable = [
        'nomor', 'nama', 'nisn', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin',
        'asal_sekolah', 'nama_wali', 'telepon_wali', 'alamat', 'jurusan_id',
        'dokumen', 'status', 'catatan',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }
}
