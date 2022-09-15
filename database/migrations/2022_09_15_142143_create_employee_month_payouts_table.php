<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeMonthPayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //mp_id, emp_id, month, financial_year, basic, hra, earnings, deductions, bonus, commission, reimburstment, adjustments, hold_salary, gross_salary, net_salary, outflow, payroll_type='regular, payment_status[pending/paid], salary_paid_at, transaction_id
        Schema::create('employee_month_payouts', function (Blueprint $table) {
            $table->id();
            $table->char('month', 2)->nullable();
            $table->char('financial_year', 4)->nullable();
            $table->double('basic')->nullable();
            $table->double('earnings')->nullable();
            $table->double('deductions')->nullable();
            $table->double('bonus')->nullable();
            $table->double('commision')->nullable();
            $table->double('reimburstment')->nullable();
            $table->double('adjustment')->nullable();
            $table->double('net_salary')->nullable();
            $table->double('outflow')->nullable();
            $table->enum('payment_status', ['UnPaid', 'Paid'])->nullable();
            $table->timestamp('salary_paid_at')->nullable();
            $table->timestamps();
            $table->foreignId('emp_id')->constrained('employees', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('mp_id')->constrained('monthly_payouts', 'id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_month_payouts');
    }
}
