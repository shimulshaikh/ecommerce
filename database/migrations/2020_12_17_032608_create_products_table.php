<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('category_id')->unsigned()->index();
            $table->bigInteger('section_id')->unsigned()->index();
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_color');
            $table->float('product_price');
            $table->float('product_discount');
            $table->float('product_weight');
            $table->string('product_video');
            $table->string('main_image');
            $table->text('description');
            $table->string('wash_care');
            $table->string('fabric');
            $table->string('pattern');
            $table->string('sleeve');
            $table->string('fit');
            $table->string('occasion');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
            $table->enum('is_featured',['No','Yes']);
            $table->tinyInteger('status');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
}
