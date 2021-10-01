<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignDonorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_donors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("i_campaigns");
            $table->bigInteger("i_donors");
            $table->tinyInteger("status")->comment("0 pending , 1 approved, 2 rejected");
            $table->timestamp("time");
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
        Schema::dropIfExists('campaign_donors');
    }
}
