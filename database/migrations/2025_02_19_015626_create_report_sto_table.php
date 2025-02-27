<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('report_sto', function (Blueprint $table) {
      $table->id();
      $table->date('issued_date');
      // $table->foreignId('inventory_id')
      //   ->constrained('inventory', 'inventory_id')
      //   ->onDelete('cascade');
      $table->string('inventory_id');

      $table->foreignId('prepared_by')
        ->constrained('users')
        ->onDelete('cascade');

      $table->foreignId('checked_by')
        ->nullable()
        ->constrained('users')
        ->onDelete('cascade');

      $table->string('status');
      $table->integer('qty_per_box');
      $table->integer('qty_box');
      $table->integer('total');
      $table->integer('grand_total');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('report_sto');
  }
};