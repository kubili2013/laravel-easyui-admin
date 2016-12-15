<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',24);
            $table->string('url',64);
            $table->string('action_type',12);
            $table->string('description',64);
            $table->string('doc',255)->nullable();
            $table->integer('parent_id')->unsigned()->default(0);
            $table->timestamps();
        });
        Schema::create('action_permission', function (Blueprint $table) {
            $table->integer('action_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->primary(['action_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('action_permission');
        Schema::dropIfExists('actions');
    }
}
