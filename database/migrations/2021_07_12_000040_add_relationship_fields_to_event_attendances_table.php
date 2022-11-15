<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEventAttendancesTable extends Migration
{
    public function up()
    {
        Schema::table('event_attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id', 'event_fk_3686446')->references('id')->on('events');
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id', 'member_fk_3686447')->references('id')->on('users');
        });
    }
}
