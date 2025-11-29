<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'ai_usage_count')) {
                $table->integer('ai_usage_count')->default(0);
            }
            if (!Schema::hasColumn('users', 'last_ai_usage_date')) {
                $table->date('last_ai_usage_date')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['ai_usage_count', 'last_ai_usage_date']);
        });
    }
};