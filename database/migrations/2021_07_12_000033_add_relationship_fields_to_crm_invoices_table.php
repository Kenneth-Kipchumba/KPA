<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCrmInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('crm_invoices', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id', 'member_fk_3676053')->references('id')->on('users');
            $table->unsignedBigInteger('rate_id')->nullable();
            $table->foreign('rate_id', 'rate_fk_3695012')->references('id')->on('rates');
        });
    }
}
