<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->string('category')->nullable()->after('activity');
        });

        DB::table('activity_logs')->whereIn('activity', ['LOGIN', 'LOGOUT', 'DOWNLOAD', 'PROFILE', 'PASSWORD'])->update(['category' => 'activity']);
        DB::table('activity_logs')->whereIn('activity', ['UPLOAD', 'EDIT', 'DELETE', 'SETTINGS'])->update(['category' => 'system']);

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->string('category', 20)->nullable(false)->default('activity')->change();
        });
    }

    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
