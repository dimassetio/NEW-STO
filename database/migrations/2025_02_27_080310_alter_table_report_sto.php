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
    Schema::table('report_sto', function (Blueprint $table) {
      $table->string('inventory_id')->nullable()->change();
      $table->unsignedBigInteger('id_inventory')->after('inventory_id');
      $table->foreign('id_inventory')
        ->references('id')
        ->on('inventory')
        ->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('report_sto', function (Blueprint $table) {
      $table->string('inventory_id')->nullable(false)->change();
      $table->dropForeign(['id_inventory']);
      $table->dropColumn('id_inventory');
    });
  }
};