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
        Schema::table('transaksi', function (Blueprint $table) {
            $table->softDeletes();
            $table->text('alasan_hapus')->nullable()->after('keterangan');
            $table->foreignId('user_id_hapus')->nullable()->after('alasan_hapus')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropForeign(['user_id_hapus']);
            $table->dropColumn(['user_id_hapus', 'alasan_hapus']);
            $table->dropSoftDeletes();
        });
    }
};
