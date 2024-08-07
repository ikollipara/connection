<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("events", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table
                ->foreignUuid("user_id")
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->jsonb("description")->nullable();
            $table->string("location")->nullable();
            $table->date("start_date");
            $table->date("end_date")->nullable();
            $table->time("start_time")->nullable();
            $table->time("end_time")->nullable();
            $table->boolean("is_all_day")->default(false);
            $table->metadata();
            $table->softDeletes();
            $table->string("display_picture")->default("");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("events");
    }
}
