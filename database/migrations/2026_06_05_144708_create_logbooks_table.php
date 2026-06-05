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
        Schema::create('logbooks', function (Blueprint $table) {
           $table->id();

$table->foreignId('internship_id');

$table->integer('week_number');

$table->text('tasks');
$table->text('reflection')->nullable();
$table->text('problems')->nullable();
$table->text('lessons_learned')->nullable();

$table->boolean('approved')->default(false);

$table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logbooks');
    }
};
