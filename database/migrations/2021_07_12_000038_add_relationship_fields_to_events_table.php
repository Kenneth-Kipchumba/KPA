<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToEventsTable extends Migration
{
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->unsignedBigInteger('specialization_id')->nullable();
            $table->foreign('specialization_id', 'specialization_fk_3725592')->references('id')->on('specializations');
        });
    }
}
