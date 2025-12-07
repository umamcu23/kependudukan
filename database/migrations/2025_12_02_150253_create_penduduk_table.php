<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('provinsi');
            $table->string('umur', 10);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->year('tahun');
            $table->unsignedBigInteger('jumlah');
            $table->timestamps();

            $table->index(['provinsi', 'umur', 'jenis_kelamin', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
