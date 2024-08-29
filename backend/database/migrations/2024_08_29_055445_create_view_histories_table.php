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
        Schema::create('view_histories', function (Blueprint $table) {
            $table->id();

            $table->integer("score")->default(0);

            $table->foreignId("user_id")->constrained();
            $table->foreignId("keyword_id")->constrained();

            $table->unique(["user_id", "keyword_id"]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('view_histories');
    }
};
