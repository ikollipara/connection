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
        Schema::dropIfExists('attendees');
        Schema::dropIfExists('events');

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('location')->default('');
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('cloned_from')->nullable()->default(null)->constrained('events')->nullOnDelete();
            $table->time('start');
            $table->time('end')->nullable();
            $table->metadata();
            $table->timestamps();
        });

        Schema::create('attendees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['event_id', 'user_id']);
        });

        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        throw new \Exception('This migration cannot be reversed');
    }
};
