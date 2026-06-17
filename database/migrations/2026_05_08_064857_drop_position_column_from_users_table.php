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
        Schema::table('users', function (Blueprint $row) {
            // Kita hapus kolom position yang lama (string)
            if (Schema::hasColumn('users', 'position')) {
                $row->dropColumn('position');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $row) {
            // Untuk rollback, kita kembalikan kolomnya sebagai string
            $row->string('position')->nullable();
        });
    }
};
