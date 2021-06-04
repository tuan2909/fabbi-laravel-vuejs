<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthPatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_patients', function (Blueprint $table) {
            $table->id();
            $table->integer('patient_id')->nullable(false)->comment('Id bệnh nhân');
            $table->boolean('fever')->default(false)->comment('Sốt');
            $table->boolean('cough')->default(false)->comment('Ho');
            $table->boolean('difficulty_breathing')->default(false)->comment('Khó thở');
            $table->boolean('sore_throat')->default(false)->comment('Đau họng');
            $table->boolean('vomiting')->default(false)->comment('Nôn mửa');
            $table->boolean('diarrhea')->default(false)->comment('Tiêu chảy');
            $table->boolean('skin_haemorrhage')->default(false)->comment('Sốt');
            $table->boolean('rash')->default(false)->comment('Xuất huyết da');
            $table->text('other')->comment('Bệnh khác');
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
        Schema::dropIfExists('health_patients');
    }
}
