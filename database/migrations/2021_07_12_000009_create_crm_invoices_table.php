<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmInvoicesTable extends Migration
{
    public function up()
    {
        Schema::create('crm_invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('invoice_no')->unique();
            $table->float('amount', 15, 2);
            $table->float('paid', 15, 2);
            $table->float('balance', 15, 2)->nullable();
            $table->float('discount', 15, 2)->nullable();
            $table->longText('notes')->nullable();
            $table->longText('items')->nullable();
            $table->longText('file')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }
}
