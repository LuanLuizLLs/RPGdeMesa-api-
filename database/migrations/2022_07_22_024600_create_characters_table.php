<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('characters', function (Blueprint $table) {
      $table->id();
      $table->foreignId('id_user')->constrained()->references('id')->on('users');
      $table->integer('id_campaign')->nullable();
      $table->string('name')->nullable();
      $table->string('description')->nullable();
      $table->string('race')->nullable();
      $table->string('caste')->nullable();
      $table->string('tendency')->nullable();
      $table->integer('life')->nullable();
      $table->integer('coins')->nullable();
      $table->integer('actions')->nullable();
      $table->integer('strength')->nullable();
      $table->integer('dexterity')->nullable();
      $table->integer('constitution')->nullable();
      $table->integer('intelligence')->nullable();
      $table->integer('wisdom')->nullable();
      $table->integer('charisma')->nullable();
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
    Schema::dropIfExists('characters');
  }
}
