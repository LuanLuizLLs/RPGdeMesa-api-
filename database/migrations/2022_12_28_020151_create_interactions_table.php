<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractionsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('interactions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_campaign')->constrained()->references('id')->on('campaigns');
      $table->string('name')->nullable();
      $table->string('description')->nullable();
      $table->integer('life')->nullable();
      $table->integer('damage')->nullable();
      $table->integer('strength')->nullable();
      $table->integer('dexterity')->nullable();
      $table->integer('constitution')->nullable();
      $table->integer('intelligence')->nullable();
      $table->integer('wisdom')->nullable();
      $table->integer('charisma')->nullable();
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
    Schema::dropIfExists('interactions');
  }
}
