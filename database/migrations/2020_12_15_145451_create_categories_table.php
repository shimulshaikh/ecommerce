<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->unsigned()->index();
            $table->bigInteger('section_id')->unsigned()->index();
            $table->string('category_name');
            $table->string('category_image');
            $table->float('category_discount');
            $table->text('description');
            $table->string('url');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
