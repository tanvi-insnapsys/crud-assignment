<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_project', function (Blueprint $table) {
            // $table->increments('id');

            // $table->unsignedInteger('employee_id')->index();
            $table->foreignId('employee_id')->constrained()
                ->on('employees')
                ->onDelete('cascade');

                $table->foreignId('project_id')->constrained()
                ->on('projects')
                ->onDelete('cascade');  

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
        Schema::dropIfExists('emolpyee_project');
    }
}
