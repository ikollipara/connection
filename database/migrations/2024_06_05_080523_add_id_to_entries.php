<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddIdToEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->renameColumn('post_id', 'content_id');
        });

        Schema::disableForeignKeyConstraints();
        DB::statement('ALTER TABLE entries DROP CONSTRAINT entries_collection_id_foreign');
        DB::statement('ALTER TABLE entries DROP CONSTRAINT post_post_collection_post_id_foreign');
        DB::statement('ALTER TABLE entries DROP CONSTRAINT post_post_collection_post_id_post_collection_id_unique');
        DB::statement('ALTER TABLE entries DROP PRIMARY KEY');
        DB::statement('ALTER TABLE entries ADD id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY');
        DB::statement(
            'ALTER TABLE entries ADD CONSTRAINT entries_collection_id_foreign FOREIGN KEY (collection_id) REFERENCES content(id) ON DELETE CASCADE',
        );
        DB::statement(
            'ALTER TABLE entries ADD CONSTRAINT entries_content_id_foreign FOREIGN KEY (content_id) REFERENCES content(id) ON DELETE CASCADE',
        );
        DB::statement(
            'ALTER TABLE entries ADD CONSTRAINT entries_collection_id_content_id_unique UNIQUE (collection_id, content_id)',
        );
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entries', function (Blueprint $table) {
            $table->renameColumn('content_id', 'post_id');
        });
        Schema::disableForeignKeyConstraints();
        DB::statement('ALTER TABLE entries DROP CONSTRAINT entries_user_id_foreign');
        DB::statement('ALTER TABLE entries DROP CONSTRAINT entries_content_id_foreign');
        DB::statement('ALTER TABLE entries DROP PRIMARY KEY');
        DB::statement('ALTER TABLE entries DROP COLUMN id');
        DB::statement('ALTER TABLE entries DROP CONSTRAINT entries_user_id_content_id_unique');
        DB::statement(
            'ALTER TABLE entries ADD CONSTRAINT post_post_collection_post_id_foreign FOREIGN KEY (post_id) REFERENCES content(id)',
        );
        DB::statement(
            'ALTER TABLE entries ADD CONSTRAINT post_post_collection_post_id_post_collection_id_unique UNIQUE (post_id, post_collection_id)',
        );
        DB::statement('ALTER TABLE entries ADD PRIMARY KEY (post_id, post_collection_id)');
        DB::statement(
            'ALTER TABLE entries ADD CONSTRAINT entries_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id)',
        );
        DB::statement(
            'ALTER TABLE entries ADD CONSTRAINT entries_post_id_foreign FOREIGN KEY (post_id) REFERENCES content(id)',
        );
    }
}
