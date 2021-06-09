<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpecimensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('specimens', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id')->nullable(false)->comment('Id bệnh nhân');
            $table->dateTime('date_infection')->nullable(false)->comment('Ngày nhiễm bệnh');
            $table->dateTime('date_draw_blood')->nullable(false)->comment('Ngày lấy máu');
            $table->dateTime('date_test')->nullable(false)->comment('Ngày kiểm tra');
            $table->dateTime('result_test')->nullable(false)->comment('Ngày kiểm tra');
            $table->dateTime('address')->nullable(false)->comment('Địa chỉ xét nghiệm');
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
        Schema::dropIfExists('specimens');
    }
}
