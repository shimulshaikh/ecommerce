<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('products')) {
            
            Schema::table('products', function (Blueprint $table) {
                
                if (!Schema::hasColumn('products', 'brand_id')) {
                    $table->bigInteger('brand_id')->unsigned()->index()->after('section_id');
                    
                    $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
                }
            });   
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('brand_id');
        });
    }
}
