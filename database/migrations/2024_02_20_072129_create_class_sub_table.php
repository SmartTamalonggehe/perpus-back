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
        Schema::create('class_sub', function (Blueprint $table) {
            $table->id();
            // foreign to class_umum
            $table->foreignId('class_umum_id')->constrained('class_umum')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->string('nm_sub');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_sub');
    }
};
