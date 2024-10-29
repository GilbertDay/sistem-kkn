<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = ['judul','kelompok_id','file','status','created_at','updated_at'];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id');
    }

}
