<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdjustEventTableDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
        });

        $eventTimes = DB::table('events')->select(['id', 'start_date', 'end_date', 'start_time', 'end_time'])->get();
        $eventTimes->each(function ($event) {
            $start = Carbon::createFromFormat('Y-m-d', $event->start_date);
            if($event->start_time) {
                $start->setTimeFrom($event->start_time);
            }
            $end = $event->end_date ? Carbon::createFromFormat('Y-m-d', $event->end_date)->setTimeFrom($event->end_time) : null;
            DB::table('events')->where('id', $event->id)->update([
                'start' => $start,
                'end' => $end,
            ]);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dateTime('start')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $eventTimes = DB::table('events')->select(['id', 'start', 'end'])->get();
        $eventTimes->each(function ($event) {
            DB::table('events')->where('id', $event->id)->update([
                'start_date' => $event->start->toDateString(),
                'end_date' => $event->end ? $event->end->toDateString() : null,
                'start_time' => $event->start->toTimeString(),
                'end_time' => $event->end ? $event->end->toTimeString() : null,
            ]);
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('start');
            $table->dropColumn('end');
            $table->date("start_date");
            $table->date("end_date")->nullable();
            $table->time("start_time")->nullable();
            $table->time("end_time")->nullable();
        });
    }
}
