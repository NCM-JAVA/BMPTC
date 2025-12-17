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
        Schema::create('hazard_states', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hazard_id')->constrained('hazards')->onDelete('cascade');
            $table->foreignId('state_id')->constrained('states')->onDelete('cascade');
            $table->enum('severity', ['Low', 'Medium', 'High', 'Critical'])->default('Low');
            $table->text('description')->nullable();
            $table->string('attachment')->nullable();
            $table->text('coordinates')->nullable();
            $table->string('source')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hazard_states');
    }
};
