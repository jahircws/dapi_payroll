<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_deductions', function (Blueprint $table) {
            $table->id();
            $table->enum('deduction_options', ['taxable', 'non-taxable'])->nullabel();
            $table->string('title')->nullable();
            $table->enum('type', ['fixed', 'percent'])->nullabel();
            $table->double('deduct_value')->default(0);
            $table->double('calc_deduct')->default(0);
            $table->timestamps();
            $table->foreignId('emp_id')->constrained('employees', 'id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_deductions');
    }
}
