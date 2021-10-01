<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsEmailTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_email_templates', function (Blueprint $table) {
            $table->id();
            $table->string("name",191)->nullable();
            $table->string("action",191)->nullable();
            $table->string("subject",191)->nullable();
            $table->text("email_body")->nullable();
            $table->text("sms_body")->nullable();
            $table->text("short_codes")->nullable();
            $table->boolean("email_status")->default(false);
            $table->boolean("sms_status")->default(false);
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
        Schema::dropIfExists('sms_email_templates');
    }
}
