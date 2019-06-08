<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddedUserProfileFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('firstname')->after('email')->nullable();
            $table->string('lastname')->after('firstname')->nullable();
            // $table->text('address')->after('lastname')->nullable();
            // $table->string('city')->after('address')->nullable();
            // $table->char('zipcode')->after('city')->nullable();
            $table->string('country')->after('lastname')->nullable();
            // $table->string('company')->after('country')->nullable();
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
            $table->dropColumn('firstname');
            $table->dropColumn('lastname');
            // $table->dropColumn('address');
            // $table->dropColumn('city');
            // $table->dropColumn('zipcode');
            $table->dropColumn('country');
            // $table->dropColumn('company');
        });
    }
}
