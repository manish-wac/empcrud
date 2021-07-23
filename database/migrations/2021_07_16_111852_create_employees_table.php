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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->text('photo');
            $table->text('password');
            $table->text('address');
            $table->unsignedBigInteger('dept_id');
            $table->unsignedBigInteger('design_id');
            $table->integer('block')->default(0);
            $table->foreign('dept_id')->references('id')->on('departments');
            $table->foreign('design_id')->references('id')->on('designations');
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
        Schema::dropIfExists('employees');
    }
}
