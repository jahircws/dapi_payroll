<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->unique();
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->char('phone', 15)->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->text('address')->nullable();
            $table->char('emirates_id', '18')->nullable();
            $table->date('emirates_exp')->nullable();
            $table->date('date_of_joining')->nullable();
            $table->timestamps();
            $table->foreignId('designation_id')->constrained('designations', 'id')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('department_id')->constrained('departments', 'id')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
