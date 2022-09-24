<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('campaigns', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_user')->constrained()->references('id')->on('users');
      $table->integer('id_adventure')->nullable();
      $table->integer('id_scenery')->nullable();
      $table->string('name');
      $table->string('description');
      $table->string('period');
      $table->string('season');
      $table->integer('ground');
      $table->integer('resources');
      $table->integer('climate');
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
    Schema::dropIfExists('campaigns');
  }
}
