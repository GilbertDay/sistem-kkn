<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// use App\Models\Padukuhan;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daftar_kkns', function (Blueprint $table) {
            $table->id();
            // $table->foreignIdFor(Padukuhan::class,'padukuhan_id')->constrained('padukuhans');
            $table->string('tahun')->nullable();
            $table->string('semester')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('tema')->nullable();
            $table->string('tipe')->nullable()->in('reguler', 'tematik');
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_kkns');
    }
};
