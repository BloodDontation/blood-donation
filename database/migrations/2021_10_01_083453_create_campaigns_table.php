<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string("name",255)->nullable();
            $table->string("location",255)->nullable();
            $table->string("description",500)->nullable();
            $table->string("logo",300)->nullable();
            $table->boolean("status")->default(0);
            $table->integer("total_donor")->default(0);
            $table->integer("donor_per_hour")->default(0);
            $table->boolean("registration_status")->default(0);
            $table->bigInteger("i_societies");

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
        Schema::dropIfExists('campaigns');
    }
}
