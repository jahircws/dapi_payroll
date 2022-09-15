<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonthlyPayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //id, month, year, total_basic, total_earnings, total_deductions, total_bonus, total_commision, total_reimburstment, total_hold_salary, net_salary, total_outflow, status[NOT_PROCESSED/PROCESSED_NOT_PAID/PROCESSED_PAID]
        Schema::create('monthly_payouts', function (Blueprint $table) {
            $table->id();
            $table->char('month', 2)->nullable();
            $table->char('financial_year', 4)->nullable();
            $table->double('total_basic')->nullable();
            $table->double('total_earnings')->nullable();
            $table->double('total_deductions')->nullable();
            $table->double('total_bonus')->nullable();
            $table->double('total_commision')->nullable();
            $table->double('total_reimburstment')->nullable();
            $table->double('total_adjustment')->nullable();
            $table->double('net_salary')->nullable();
            $table->double('total_outflow')->nullable();
            $table->enum('status', ['NOT_PROCESSED', 'PROCESSED_NOT_PAID', 'PROCESSED_PAID'])->nullable();
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
        Schema::dropIfExists('monthly_payouts');
    }
}
