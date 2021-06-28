<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('type_patients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Tên loại bệnh nhân');
            $table->bigInteger('number_type')->unique()->nullable()->comment('Số thứ tự');
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
        Schema::dropIfExists('type_patients');
    }
}
