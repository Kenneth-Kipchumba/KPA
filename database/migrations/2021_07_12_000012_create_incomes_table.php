<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomesTable extends Migration
{
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('entry_date')->nullable();
            $table->string('receipt_no')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('mode')->nullable();
            $table->string('transaction_no')->nullable();
            $table->longText('notes')->nullable();
            $table->longText('items')->nullable();
            $table->longText('file')->nullable();
            $table->timestamps();
        });
    }
}
