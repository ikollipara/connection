<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("user_settings", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignUuid("user_id")
                ->constrained()
                ->cascadeOnDelete();
            $table->boolean("receive_weekly_digest");
            $table->boolean("receive_comment_notifications");
            $table->boolean("receive_new_follower_notifications");
            $table->boolean("receive_follower_notifications");
            $table->timestamps();
        });

        DB::transaction(function () {
            $settings = DB::table("users")
                ->select([
                    "id as user_id",
                    "receive_weekly_digest",
                    "no_comment_notifications",
                ])
                ->get();

            foreach ($settings as $setting) {
                DB::table("user_settings")->insert([
                    "user_id" => $setting->user_id,
                    "receive_weekly_digest" => $setting->receive_weekly_digest,
                    "receive_comment_notifications" => !$setting->no_comment_notifications,
                    "receive_new_follower_notifications" => true,
                    "receive_follower_notifications" => true,
                ]);
            }
        });

        Schema::table("users", function (Blueprint $table) {
            $table->dropColumn("receive_weekly_digest");
            $table->dropColumn("no_comment_notifications");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("users", function (Blueprint $table) {
            $table->boolean("receive_weekly_digest")->default(false);
            $table->boolean("no_comment_notifications")->default(false);
        });
        DB::transaction(function () {
            $settings = DB::table("user_settings")
                ->select([
                    "user_id",
                    "receive_weekly_digest",
                    "receive_comment_notifications",
                ])
                ->get();

            foreach ($settings as $setting) {
                DB::table("users")
                    ->where("id", $setting->user_id)
                    ->update([
                        "receive_weekly_digest" =>
                            $setting->receive_weekly_digest,
                        "no_comment_notifications" => !$setting->receive_comment_notifications,
                    ]);
            }
        });
        Schema::dropIfExists("user_settings");
    }
}
