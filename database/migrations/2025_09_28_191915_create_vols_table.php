<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vols', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->dateTime('date_depart');
            $table->dateTime('date_arrive');
            $table->string('origine', 255);
            $table->string('destination', 255);
            $table->decimal('prix', 10, 2)->unsigned();
            $table->boolean('efface')->default(0);
            $table->timestamps();

            $table->foreignId('avion_id')
            ->references('id')
            ->on('avions')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vols');
    }
}
