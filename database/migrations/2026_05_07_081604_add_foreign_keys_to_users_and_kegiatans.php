<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // 1. Update Tabel Users (Menambah Relasi Jabatan)
        Schema::table('users', function (Blueprint $table) {
            // Kita gunakan foreignId agar lebih ringkas (fitur Laravel modern)
            // constrained() otomatis merujuk ke tabel 'positions'
            $table->foreignId('position_id')
                ->nullable()
                ->after('id') // diletakkan setelah kolom id
                ->constrained('positions')
                ->onDelete('set null');
        });

        // 2. Update Tabel Kegiatans (Menambah Relasi Kategori)
        Schema::table('kegiatans', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->nullable()
                ->after('id')
                ->constrained('categories')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['position_id']);
            $table->dropColumn('position_id');
        });

        Schema::table('kegiatans', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
