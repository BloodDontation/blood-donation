<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuperAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('super_admins', function (Blueprint $table) {
            $table->id();
            $table->string("username",30)->unique();
            $table->string("password",255)->nullable();
            $table->string("name",50)->nullable();
            $table->string("phone",17)->nullable();
            $table->string("type",10)->nullable();
            $table->string("email",255)->unique();
            $table->integer("cpr")->unique();
            $table->tinyInteger("status")->comment("0 pending , 1 approved, 2 rejected")->default(0);


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
        Schema::dropIfExists('super_admins');
    }
}
