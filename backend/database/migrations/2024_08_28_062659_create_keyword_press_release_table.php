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
        Schema::create('keyword_press_release', function (Blueprint $table) {
            $table->id();

            $table->integer("weight")->default(0);

            $table->foreignId("press_release_id")->constrained();
            $table->foreignId("keyword_id")->constrained();

            $table->unique(["keyword_id", "press_release_id"]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keyword_press_release');
    }
};
