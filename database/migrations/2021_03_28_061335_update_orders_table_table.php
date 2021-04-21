<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'courier_name')) {
                    $table->string('courier_name')->nullable()->after('grand_total');
                }
                if (!Schema::hasColumn('orders', 'tracking_number')) {
                    $table->string('tracking_number')->nullable()->after('courier_name');
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('courier_name');
            $table->dropColumn('tracking_number');
        });
    }
}
