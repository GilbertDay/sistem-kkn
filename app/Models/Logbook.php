<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','padukuhan_id','taggal','isi','status'];

    public function padukuhan()
    {
        return $this->belongsTo(Kelompok::class, 'padukuhan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
