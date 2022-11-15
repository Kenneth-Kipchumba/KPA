<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('list');
            $table->longText('custom_list')->nullable();
            $table->string('subject');
            $table->longText('message');
            $table->timestamps();
        });
    }
}
