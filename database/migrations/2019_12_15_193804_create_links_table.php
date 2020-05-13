<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url');
            $table->string('tld');
            $table->string('tiny');
            $table->string('xtiny')->nullable();
            $table->string('type')->default('single');
            $table->bigInteger('views')->default(0);
            $table->bigInteger('state')->default(1);
            $table->date('registered_at');
            $table->string('ip');
            $table->dateTime('deactivate')->nullable();
            $table->timestamps();
        });
        Schema::create('link_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('link_id')->unsigned();
            $table->primary(['user_id', 'link_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('links');
    }
}
