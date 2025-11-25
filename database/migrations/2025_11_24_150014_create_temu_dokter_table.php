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
        Schema::create('temu_dokter', function (Blueprint $table) {
            $table->integer('idreservasi_dokter', true); // Primary key with auto increment
            $table->integer('no_urut')->nullable();
            $table->timestamp('waktu_daftar')->nullable();
            $table->char('status', 1)->default('0'); // 0=menunggu, 1=selesai, 2=batal
            $table->integer('idrole_user'); // Foreign key to role_user table (dokter)
            
            // Foreign key constraints
            $table->foreign('idrole_user')
                  ->references('idrole_user')
                  ->on('role_user')
                  ->onDelete('cascade');
            
            // Indexes
            $table->index('idrole_user', 'fk_temu_dokter_role_user1_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temu_dokter');
    }
};
