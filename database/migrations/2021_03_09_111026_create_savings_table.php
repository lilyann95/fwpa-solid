<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->string('name_id');
            $table->string('date');
            $table->string('name');
            $table->string('monthly_contribution');
            $table->string('late_payment')->default('0');
            $table->string('late_meeting')->default('0');
            $table->string('absenteeism')->default('0');
            $table->string('marriage')->nullable()->default('0');
            $table->string('birth')->default('0');
            $table->string('graduation')->nullable()->default('0');
            $table->string('consecration')->nullable()->default('0');
            $table->string('sickness')->nullable()->default('0');
            $table->string('death')->default('0');
            $table->string('total_amount');
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
        Schema::dropIfExists('savings');
    }
}
