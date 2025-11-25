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
        Schema::table('rekam_medis', function (Blueprint $table) {
            // Add optional foreign key to temu_dokter
            $table->integer('idreservasi_dokter')->nullable()->after('dokter_pemeriksa');
            
            // Add foreign key constraint
            $table->foreign('idreservasi_dokter')
                  ->references('idreservasi_dokter')
                  ->on('temu_dokter')
                  ->onDelete('set null'); // If appointment is deleted, medical record remains
            
            // Add index
            $table->index('idreservasi_dokter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rekam_medis', function (Blueprint $table) {
            // Drop foreign key constraint and column
            $table->dropForeign(['idreservasi_dokter']);
            $table->dropIndex(['idreservasi_dokter']);
            $table->dropColumn('idreservasi_dokter');
        });
    }
};
