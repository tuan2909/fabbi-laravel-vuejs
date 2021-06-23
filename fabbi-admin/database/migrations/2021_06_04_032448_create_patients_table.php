<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable(false)->comment('Id Người dùng');
            $table->integer('type_id')->nullable(false)->comment('Id loại bệnh nhân');
            $table->integer('city_id')->nullable(false)->comment('Id thành phố');
            $table->string('full_name')->nullable(false)->comment('Họ và tên bệnh nhân');
            $table->integer('citizen_identify')->nullable(false)->comment('CMND/CCCD bệnh nhân');
            $table->boolean('gender')->default(true)->comment('Giới tính');
            $table->string('nation')->nullable(false)->comment('Quốc tịch');
            $table->integer('year_birth')->nullable()->comment('Năm sinh');
            $table->text('address')->comment('Địa chỉ bệnh nhân');
            $table->string('number')->nullable()->comment('Số điện thoại');
            $table->string('email')->comment('email bệnh nhân');
            $table->text('address_start')->nullable(false)->comment('Địa chỉ bắt đầu di chuyển');
            $table->text('address_end')->nullable(false)->comment('Địa chỉ cuối');
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
        Schema::dropIfExists('patients');
    }
}
