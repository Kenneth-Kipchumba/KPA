<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventAttendancesTable extends Migration
{
    public function up()
    {
        Schema::create('event_attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('dates')->nullable();
            $table->string('receipt_no')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });
    }
}
