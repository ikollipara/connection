<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddIdToViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("views", function (Blueprint $table) {
            $table->renameColumn("post_id", "content_id");
        });
        Schema::disableForeignKeyConstraints();
        DB::statement("ALTER TABLE views DROP CONSTRAINT post_views_user_id_foreign");
        DB::statement("ALTER TABLE views DROP CONSTRAINT post_views_post_id_foreign");
        DB::statement("ALTER TABLE views DROP PRIMARY KEY");
        DB::statement("ALTER TABLE views ADD id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY");
        DB::statement(
            "ALTER TABLE views ADD CONSTRAINT views_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE",
        );
        DB::statement(
            "ALTER TABLE views ADD CONSTRAINT views_content_id_foreign FOREIGN KEY (content_id) REFERENCES content(id) ON DELETE CASCADE",
        );
        DB::statement("ALTER TABLE views ADD CONSTRAINT views_user_id_content_id_unique UNIQUE (user_id, content_id)");
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table("views", function (Blueprint $table) {
            $table->renameColumn("content_id", "post_id");
        });
        Schema::disableForeignKeyConstraints();
        DB::statement("ALTER TABLE views DROP CONSTRAINT views_user_id_foreign");
        DB::statement("ALTER TABLE views DROP CONSTRAINT views_content_id_foreign");
        DB::statement("ALTER TABLE views DROP PRIMARY KEY");
        DB::statement("ALTER TABLE views DROP COLUMN id");
        DB::statement("ALTER TABLE views DROP CONSTRAINT views_user_id_content_id_unique");
        DB::statement(
            "ALTER TABLE views ADD CONSTRAINT post_views_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id)",
        );
        DB::statement(
            "ALTER TABLE views ADD CONSTRAINT post_views_post_id_foreign FOREIGN KEY (post_id) REFERENCES content(id)",
        );
        DB::statement("ALTER TABLE views ADD PRIMARY KEY (user_id, post_id)");
        Schema::enableForeignKeyConstraints();
    }
}
