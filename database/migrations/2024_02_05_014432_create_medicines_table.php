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
        Schema::create('medicines', function (Blueprint $table) {
            $table->id();
            $table->string('general_description')->nullable();
            $table->string('quantity')->nullable()->default(0);
            $table->string('unit_of_measure')->nullable();
            $table->text('how_to_use')->nullable();
            $table->text('warning')->nullable();
            $table->text('side_effect')->nullable();
            $table->text('direction')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
