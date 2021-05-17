<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuarantorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guarantors', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->string('name')->nullable()->default("NONE");
            $table->string('loanamount')->nullable()->default('0');
            $table->string('quarantor')->nullable()->default('NONE');
            $table->string('total-amount2')->nullable()->default('0');
            $table->string('expected')->nullable()->default('0');
            $table->string('g_amount')->nullable()->default('0');
            $table->string('last_payment')->nullable()->default('NONE');
            $table->string('status');
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
        Schema::dropIfExists('guarantors');
    }
}
