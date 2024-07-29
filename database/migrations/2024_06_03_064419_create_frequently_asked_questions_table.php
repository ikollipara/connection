<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrequentlyAskedQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frequently_asked_questions', function (
            Blueprint $table
        ) {
            $table->id();
            $table->string('title', 255);
            $table->text('content');
            $table
                ->foreignUuid('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->dateTime('answered_at')->nullable();
            $table->text('answer')->nullable();
            $table->jsonb('history');
            $table->timestamps();
            $table->softDeletes();

            $table->fullText(['title', 'content', 'answer']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('frequently_asked_questions');
    }
}
