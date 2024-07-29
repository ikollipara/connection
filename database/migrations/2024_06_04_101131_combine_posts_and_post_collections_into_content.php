<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CombinePostsAndPostCollectionsIntoContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the foreign post_collection key from the post_post_collection table
        Schema::table('post_post_collection', function (Blueprint $table) {
            $table->dropForeign('post_post_collection_post_collection_id_foreign');
            $table->renameColumn('post_collection_id', 'collection_id');
        });
        Schema::rename('post_post_collection', 'entries');
        Schema::table('posts', function (Blueprint $table) {
            $table->string('type')->nullable();
        });
        DB::table('posts')->update(['type' => 'post']);
        Schema::rename('posts', 'content');
        $collections = DB::table('post_collections')->get();
        foreach ($collections as $collection) {
            $collection->type = 'collection';
        }
        DB::table('content')->insert($collections->map(fn ($collection) => (array) $collection)->toArray());
        $likes = DB::table('post_collection_likes')->get();
        $views = DB::table('post_collection_views')->get();
        foreach ($likes as $like) {
            $like->post_id = $like->post_collection_id;
            unset($like->post_collection_id);
            DB::table('post_likes')->insert((array) $like);
        }
        foreach ($views as $view) {
            $view->post_id = $view->post_collection_id;
            unset($view->post_collection_id);
            DB::table('post_views')->insert((array) $view);
        }
        Schema::dropIfExists('post_collection_likes');
        Schema::dropIfExists('post_collection_views');
        Schema::dropIfExists('post_collections');
        Schema::table('entries', function (Blueprint $table) {
            $table
                ->foreign('collection_id')
                ->references('id')
                ->on('content')
                ->cascadeOnDelete();
        });
        Schema::rename('post_likes', 'content_likes');
        Schema::rename('post_views', 'views');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        throw new \Exception('Migration cannot be reversed');
    }
}
