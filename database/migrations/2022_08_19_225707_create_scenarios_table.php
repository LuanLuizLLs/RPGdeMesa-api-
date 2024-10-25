<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScenariosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('scenarios', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_campaign')->constrained()->references('id')->on('campaigns');
      $table->string('name');
      $table->string('description');
      $table->string('region');
      $table->string('culture');
      $table->softDeletes();
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
    Schema::dropIfExists('scenarios');
  }
}
