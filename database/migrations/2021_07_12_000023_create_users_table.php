<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('member_no')->nullable();
            $table->string('name')->nullable()->unique();
            $table->string('email')->nullable()->unique();
            $table->string('phone')->nullable()->unique();
            $table->string('board_reg_no')->nullable();
            $table->string('designation')->nullable();
            $table->string('designation_other')->nullable();
            $table->string('specialization_other')->nullable();
            $table->string('workstation')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->nullable();
            $table->string('id_no')->nullable();
            $table->string('postal_address')->nullable();
            $table->string('postal_code')->nullable();
            $table->longText('bio')->nullable();
            $table->string('alt_email')->nullable();
            $table->datetime('email_verified_at')->nullable();
            $table->string('remember_token')->nullable();
            $table->string('password')->nullable();
            $table->date('date_registration')->nullable();
            $table->boolean('approved')->default(0)->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('custom_field_1')->nullable();
            $table->string('custom_field_2')->nullable();
            $table->string('custom_field_3')->nullable();
            $table->string('custom_field_4')->nullable();
            $table->string('custom_field_5')->nullable();
            $table->string('custom_field_6')->nullable();
            $table->string('custom_field_7')->nullable();
            $table->string('custom_field_8')->nullable();
            $table->string('custom_field_9')->nullable();
            $table->string('custom_field_10')->nullable();
            $table->longText('custom_text_1')->nullable();
            $table->longText('custom_text_2')->nullable();
            $table->longText('custom_text_3')->nullable();
            $table->longText('custom_text_5')->nullable();
            $table->longText('custom_text_4')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
