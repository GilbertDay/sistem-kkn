<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use App\Models\Padukuhan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kelompoks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelompok')->nullable();
            $table->foreignId('padukuhan_id')->constrained('padukuhans');
            $table->string('tema')->nullable();
            $table->foreignId('ketua_id')->unique()->constrained('users');
            $table->json('anggota')->nullable();
            $table->dateTimeTz('tanggal_mulai', 0);
            $table->dateTimeTz('tanggal_selesai', 0);
            $table->string('status')->default("aktif");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelompoks');
    }
};
