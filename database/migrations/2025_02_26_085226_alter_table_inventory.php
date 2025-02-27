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
    Schema::table('inventory', function (Blueprint $table) {
      $table->string('inventory_id')->nullable()->change();
      $table->string('category')->default('Finished Good');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('inventory', function (Blueprint $table) {
      $table->string('inventory_id')->nullable(false)->change();
      $table->dropColumn('category');
    });
  }
};