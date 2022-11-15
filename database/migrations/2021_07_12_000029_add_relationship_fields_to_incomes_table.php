<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToIncomesTable extends Migration
{
    public function up()
    {
        Schema::table('incomes', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable();
            $table->foreign('member_id', 'member_fk_3675967')->references('id')->on('users');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id', 'invoice_fk_3675968')->references('id')->on('crm_invoices');
            $table->unsignedBigInteger('income_category_id')->nullable();
            $table->foreign('income_category_id', 'income_category_fk_3667797')->references('id')->on('income_categories');
        });
    }
}
