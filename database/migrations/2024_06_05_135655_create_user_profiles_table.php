<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table
                ->foreignUuid('user_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->jsonb('bio');
            $table->boolean('is_preservice');
            $table->string('school');
            $table->string('subject');
            $table->jsonb('grades');
            $table->string('gender');
            $table->unsignedTinyInteger('years_of_experience')->default(0);
            $table->timestamps();
        });

        DB::transaction(function () {
            $profiles = DB::table('users')
                ->select([
                    'id as user_id',
                    'bio',
                    'is_preservice',
                    'school',
                    'subject',
                    'grades',
                    'gender',
                    'years_of_experience',
                ])
                ->get();

            foreach ($profiles as $profile) {
                DB::table('user_profiles')->insert([
                    'user_id' => $profile->user_id,
                    'bio' => $profile->bio,
                    'is_preservice' => $profile->is_preservice,
                    'school' => $profile->school,
                    'subject' => $profile->subject,
                    'grades' => $profile->grades,
                    'gender' => $profile->gender,
                    'years_of_experience' => $profile->years_of_experience,
                ]);
            }
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('bio');
            $table->dropColumn('is_preservice');
            $table->dropColumn('school');
            $table->dropColumn('subject');
            $table->dropColumn('grades');
            $table->dropColumn('gender');
            $table->dropColumn('years_of_experience');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->jsonb('bio');
            $table->boolean('is_preservice')->default(false);
            $table->string('school')->default('');
            $table->string('subject')->default('');
            $table->jsonb('grades');
            $table->string('gender')->default('');
            $table->unsignedTinyInteger('years_of_experience')->default(0);
        });

        DB::transaction(function () {
            $profiles = DB::table('user_profiles')
                ->select([
                    'user_id as id',
                    'bio',
                    'is_preservice',
                    'school',
                    'subject',
                    'grades',
                    'gender',
                    'years_of_experience',
                ])
                ->get();

            foreach ($profiles as $profile) {
                DB::table('users')
                    ->where('id', $profile->id)
                    ->update([
                        'bio' => $profile->bio,
                        'is_preservice' => $profile->is_preservice,
                        'school' => $profile->school,
                        'subject' => $profile->subject,
                        'grades' => $profile->grades,
                        'gender' => $profile->gender,
                        'years_of_experience' => $profile->years_of_experience,
                    ]);
            }
        });

        Schema::dropIfExists('user_profiles');
    }
}
