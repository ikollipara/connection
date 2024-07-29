<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddIdToCommentLikesAndContentLikes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('content_likes', function (Blueprint $table) {
            $table->renameColumn('post_id', 'content_id');
        });
        Schema::disableForeignKeyConstraints();
        // Comment
        DB::statement('ALTER TABLE comment_likes DROP CONSTRAINT comment_likes_user_id_foreign');
        DB::statement('ALTER TABLE comment_likes DROP CONSTRAINT comment_likes_comment_id_foreign');
        DB::statement('ALTER TABLE comment_likes DROP PRIMARY KEY');
        DB::statement('ALTER TABLE comment_likes ADD id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY');
        DB::statement(
            'ALTER TABLE comment_likes ADD CONSTRAINT comment_likes_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE',
        );
        DB::statement(
            'ALTER TABLE comment_likes ADD CONSTRAINT comment_likes_comment_id_foreign FOREIGN KEY (comment_id) REFERENCES comments(id) ON DELETE CASCADE',
        );

        DB::statement(
            'ALTER TABLE comment_likes ADD CONSTRAINT comment_likes_user_id_comment_id_unique UNIQUE (user_id, comment_id)',
        );
        // Content
        DB::statement('ALTER TABLE content_likes DROP CONSTRAINT post_likes_user_id_foreign');
        DB::statement('ALTER TABLE content_likes DROP CONSTRAINT post_likes_post_id_foreign');
        DB::statement('ALTER TABLE content_likes DROP PRIMARY KEY');
        DB::statement('ALTER TABLE content_likes ADD id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY');
        DB::statement(
            'ALTER TABLE content_likes ADD CONSTRAINT content_likes_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE',
        );
        DB::statement(
            'ALTER TABLE content_likes ADD CONSTRAINT content_likes_content_id_foreign FOREIGN KEY (content_id) REFERENCES content(id) ON DELETE CASCADE',
        );
        DB::statement(
            'ALTER TABLE content_likes ADD CONSTRAINT content_likes_user_id_content_id_unique UNIQUE (user_id, content_id)',
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
        Schema::disableForeignKeyConstraints();
        DB::statement('ALTER TABLE comment_likes DROP COLUMN id');
        DB::statement('ALTER TABLE comment_likes ADD PRIMARY KEY (user_id, comment_id)');
        DB::statement('ALTER TABLE content_likes DROP COLUMN id');
        DB::statement('ALTER TABLE content_likes ADD PRIMARY KEY (user_id, content_id)');
        Schema::enableForeignKeyConstraints();
    }
}
