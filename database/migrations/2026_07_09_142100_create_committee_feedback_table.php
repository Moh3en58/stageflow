<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('committee_feedback', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('stage_proposal_id');
            $table->unsignedBigInteger('committee_user_id');

            $table->text('feedback');
            $table->string('decision')->nullable(); // feedback, approved, rejected

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('committee_feedback');
    }
};