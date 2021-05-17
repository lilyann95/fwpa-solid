<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->string('name');
            $table->string('totalamountdue');
            $table->string('loan_semilimit');
            $table->string('loan_limit');
            $table->string('loanamount');
            $table->string('processingfee');
            $table->string('monthstaken');
            $table->string('return');
            $table->string('desc');
            $table->string('reason');
            $table->string('quarantor')->nullable()->default('NONE');
            $table->string('name_quarantor')->nullable()->default('NONE');
            $table->string('g_amount')->nullable()->default('0');
            $table->string('guarantorstatus');
            $table->string('last_payment');
            $table->string('status');
            $table->string('seize')->nullable()->default("NO");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
