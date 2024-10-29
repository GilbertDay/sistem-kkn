<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarKkn extends Model
{
    use HasFactory;

    protected $fillable = [
        'tahun',
        'semester',
        'lokasi',
        'kecamatan',
        'tema',
        'tipe',
    ];

    public function padukuhans()
    {
        return $this->hasMany(Padukuhan::class, 'daftar_kkn_id');
    }
}
