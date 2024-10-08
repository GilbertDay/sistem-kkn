<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Padukuhan extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function daftarKkn()
    {
        return $this->belongsTo(DaftarKkn::class, 'daftar_kkn_id');
    }

    public function kelompok()
    {
        return $this->hasMany(Kelompok::class, 'padukuhan_id');
    }
}
