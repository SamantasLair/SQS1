<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_answers', function (Blueprint $table) {
            $table->text('essay_answer')->nullable()->after('option_id');
            $table->uuid('option_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('user_answers', function (Blueprint $table) {
            $table->dropColumn('essay_answer');
            $table->uuid('option_id')->nullable(false)->change();
        });
    }
};