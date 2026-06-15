<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->foreignId('archive_id')->nullable()->constrained()->nullOnDelete();
            $table->string('archive_title')->nullable();
            $table->string('archive_number')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropForeign(['archive_id']);
            $table->dropColumn(['archive_id', 'archive_title', 'archive_number']);
        });
    }
};
