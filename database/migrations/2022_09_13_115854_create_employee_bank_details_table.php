<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeBankDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_bank_details', function (Blueprint $table) {
            $table->id();
            $table->string('iban')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('account_num')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('branch_address')->nullable();
            $table->string('holder_name')->nullable();
            $table->string('holder_nick_name')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('street_address')->nullable();
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
        Schema::dropIfExists('employee_bank_details');
    }
}
