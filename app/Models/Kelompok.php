<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    protected $fillable = ['nama_kelompok','padukuhan_id','ketua_id','anggota','status','created_at','updated_at','tema','tanggal_mulai','tanggal_selesai','tema'];



    public function users()
    {
        return $this->belongsTo(User::class, 'ketua_id');
    }
    public function padukuhan()
    {
        return $this->belongsTo(Padukuhan::class, 'padukuhan_id');
    }
}
