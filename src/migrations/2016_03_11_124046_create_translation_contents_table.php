<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translation_contents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tag')->nullable();
            foreach (config('locale.languages') as $one) {
                $table->text($one['iso2'])->nullable();
            }
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
        Schema::drop('translation_contents');
    }
}
