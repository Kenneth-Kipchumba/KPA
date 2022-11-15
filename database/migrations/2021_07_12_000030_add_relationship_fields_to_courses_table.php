<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCoursesTable extends Migration
{
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->unsignedBigInteger('specialization_id')->nullable();
            $table->foreign('specialization_id', 'specialization_fk_3725593')->references('id')->on('specializations');
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->foreign('teacher_id', 'teacher_fk_3667706')->references('id')->on('users');
        });
    }
}
