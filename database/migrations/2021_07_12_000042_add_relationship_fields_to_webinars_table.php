<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToWebinarsTable extends Migration
{
    public function up()
    {
        Schema::table('webinars', function (Blueprint $table) {
            $table->unsignedBigInteger('specialization_id')->nullable();
            $table->foreign('specialization_id', 'specialization_fk_4004681')->references('id')->on('specializations');
        });
    }
}
