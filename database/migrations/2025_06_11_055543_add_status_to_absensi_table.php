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
        Schema::table('absensi', function (Blueprint $table) {
            $table->string('status', 20)->default('open')->after('materi'); // Nilai bisa 'open' atau 'closed'
        });
    }

    public function down(): void
    {
        Schema::table('absensi', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
