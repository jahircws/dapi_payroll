<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //emp_id, doc_name, doc_file
        Schema::create('employee_docs', function (Blueprint $table) {
            $table->id();
            $table->string('doc_name')->nullable();
            $table->string('doc_file')->nullable();
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
        Schema::dropIfExists('employee_docs');
    }
}
