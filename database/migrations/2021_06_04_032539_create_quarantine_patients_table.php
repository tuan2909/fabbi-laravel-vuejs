<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuarantinePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quarantine_patients', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id')->nullable(false)->comment('Id bệnh nhân');
            $table->timestamp('time_start')->comment('Ngày bắt đầu cách ly');
            $table->timestamp('time_end')->comment('Ngày kết thúc cách ly');
            $table->bigInteger('total')->comment('Tổng số ngày đã cách ly');
            $table->tinyInteger('status')->default(0)->comment('Trạng thái cách lý/1:Đang cách ly,0:Chưa cách ly,-1:Đã kết thúc cách ly');
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
        Schema::dropIfExists('quarantine_patients');
    }
}
