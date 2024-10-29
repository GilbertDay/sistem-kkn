<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\DaftarKkn;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('padukuhans', function (Blueprint $table) {
            $table->id();

            // Foreign key for daftar_kkn_id, NOT unique, with cascade delete
            $table->foreignId('daftar_kkn_id')
                  ->constrained('daftar_kkns')
                  ->onDelete('cascade'); // Deletes related padukuhan if daftar_kkn is deleted

            // Foreign key for dosen_id, NOT unique, with null on delete
            $table->foreignId('dosen_id')
                  ->constrained('users')
                  ->onDelete('cascade'); // Set dosen_id to null if user (dosen) is deleted

            $table->string('nama_dukuh')->nullable();
            $table->string('desa')->nullable();
            $table->string('apl')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('padukuhans');
    }
};
