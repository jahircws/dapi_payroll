<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //earning_options[taxable/non-taxable], title, type(fixed/percent), earning_value
        Schema::create('employee_earnings', function (Blueprint $table) {
            $table->id();
            $table->enum('earning_options', ['taxable', 'non-taxable'])->nullabel();
            $table->string('title')->nullable();
            $table->enum('type', ['fixed', 'percent'])->nullabel();
            $table->double('earning_value')->default(0);
            $table->double('calc_earning')->default(0);
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
        Schema::dropIfExists('employee_earnings');
    }
}
