<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebinarsTable extends Migration
{
    public function up()
    {
        Schema::create('webinars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('date_time')->nullable();
            $table->string('title')->nullable();
            $table->string('link')->nullable();
            $table->string('video')->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }
}
