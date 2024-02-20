<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('katalog', function (Blueprint $table) {
            $table->id();
            // foreign to class_sub
            $table->foreignId('class_sub_id')->constrained('class_sub')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('judul');
            $table->string('penulis');
            $table->string('penerbit');
            $table->string('tahun');
            $table->string('jenis');
            $table->string('stok');
            $table->string('cover');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katalog');
    }
};
