<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocietiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('societies', function (Blueprint $table) {
            $table->id();
            $table->string("name",150)->nullable();
            $table->string("logo",150)->nullable();
            $table->string("city",100)->nullable();
            $table->string("sms_config",255)->nullable();
            $table->text("email_config")->nullable();
            $table->text("email_template")->nullable();
            $table->string("phone",25)->unique();

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
        Schema::dropIfExists('societies');
    }
}
