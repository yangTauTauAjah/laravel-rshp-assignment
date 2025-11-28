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
        Schema::create('perawat', function (Blueprint $table) {
            $table->id('idperawat');
            $table->string('alamat', 100);
            $table->string('no_hp', 45);
            $table->char('jenis_kelamin', 1);
            $table->string('pendidikan', 100);
            $table->bigInteger('iduser');
            $table->timestamps();

            // Foreign key constraint to user table
            $table->foreign('iduser')->references('iduser')->on('user')->onDelete('cascade');
            
            // Unique constraint to ensure one nurse profile per user
            $table->unique('iduser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perawat');
    }
};
