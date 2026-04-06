<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * CATATAN: Migration ini menghapus field harga_modal dan harga_jual
     * yang tidak digunakan di aplikasi.
     * 
     * Analisis: Lihat file ANALISIS_FIELD_TIDAK_DIGUNAKAN.md untuk detail lengkap
     */
    public function up(): void
    {
        // Drop columns dari tabel pulsa jika ada
        if (Schema::hasTable('pulsa') && Schema::hasColumn('pulsa', 'harga_modal')) {
            Schema::table('pulsa', function (Blueprint $table) {
                $table->dropColumn('harga_modal');
            });
        }

        if (Schema::hasTable('pulsa') && Schema::hasColumn('pulsa', 'harga_jual')) {
            Schema::table('pulsa', function (Blueprint $table) {
                $table->dropColumn('harga_jual');
            });
        }

        // Drop columns dari tabel kuota jika ada
        if (Schema::hasTable('kuota') && Schema::hasColumn('kuota', 'harga_modal')) {
            Schema::table('kuota', function (Blueprint $table) {
                $table->dropColumn('harga_modal');
            });
        }

        if (Schema::hasTable('kuota') && Schema::hasColumn('kuota', 'harga_jual')) {
            Schema::table('kuota', function (Blueprint $table) {
                $table->dropColumn('harga_jual');
            });
        }
    }

    /**
     * Reverse the migrations.
     * 
     * CATATAN: Rollback hanya akan menghapus kolom, tidak bisa restore data
     * Pastikan sudah backup sebelum menjalankan migration ini
     */
    public function down(): void
    {
        // Tidak bisa di-rollback karena data akan hilang
        // Jika ingin rollback, gunakan backup database
        throw new \Exception(
            'Rollback untuk migration ini tidak didukung karena akan menghapus data. ' .
            'Silakan restore dari backup database jika diperlukan.'
        );
    }
};
