<?php

declare(strict_types=1);

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
        Schema::dropIfExists('searches');

        Schema::create('searches', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->json('search_params');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('searches');

        Schema::create('searches', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('user_id')->nullable()->constrained()->nullOnDelete();
            $table->json('search_params');
            $table->timestamps();
        });
    }
};
