<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->string('evaluation_type')->default('midterm')->after('evaluator_id'); // midterm, final
            $table->string('evaluator_role')->default('mentor')->after('evaluation_type'); // mentor, student
            $table->text('comments')->nullable()->after('evaluation_date');
        });
    }

    public function down(): void
    {
        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropColumn([
                'evaluation_type',
                'evaluator_role',
                'comments',
            ]);
        });
    }
};