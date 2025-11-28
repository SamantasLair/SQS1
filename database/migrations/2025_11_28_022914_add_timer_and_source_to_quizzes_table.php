<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            if (!Schema::hasColumn('quizzes', 'timer')) {
                $table->integer('timer')->default(30);
            }
            if (!Schema::hasColumn('quizzes', 'generation_source')) {
                $table->string('generation_source')->default('manual');
            }
        });

        Schema::table('questions', function (Blueprint $table) {
            if (!Schema::hasColumn('questions', 'type')) {
                $table->string('type')->default('multiple_choice');
            }
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            $table->dropColumn(['timer', 'generation_source']);
        });
        
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};