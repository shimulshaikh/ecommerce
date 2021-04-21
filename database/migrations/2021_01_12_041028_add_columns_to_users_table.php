<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'address')) {
                    $table->string('address')->after('name');
                }
                if (!Schema::hasColumn('users', 'city')) {
                    $table->string('city')->after('address');
                }
                if (!Schema::hasColumn('users', 'state')) {
                    $table->string('state')->after('city');
                }
                if (!Schema::hasColumn('users', 'country')) {
                    $table->string('country')->after('state');
                }
                if (!Schema::hasColumn('users', 'pincode')) {
                    $table->string('pincode')->after('country');
                }
                if (!Schema::hasColumn('users', 'mobile')) {
                    $table->string('mobile')->after('pincode');
                }
                if (!Schema::hasColumn('users', 'status')) {
                    $table->tinyInteger('status')->after('password')->default(1);
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('address');
            $table->dropColumn('city');
            $table->dropColumn('state');
            $table->dropColumn('country');
            $table->dropColumn('pincode');
            $table->dropColumn('mobile');
            $table->dropColumn('status');
        });
    }
}
