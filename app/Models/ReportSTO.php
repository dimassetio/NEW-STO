<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSTO extends Model
{
  use HasFactory;

  protected $table = 'report_sto';

  protected $fillable = [
    'issued_date',
    'id_inventory',
    'inventory_id',
    'prepared_by',
    'checked_by',
    'status',
    'qty_per_box',
    'qty_box',
    'total',
    'qty_per_box_2',
    'qty_box_2',
    'total_2',
    'grand_total'
  ];

  protected $casts = [
    'issued_date' => 'datetime',
  ];

  public function inventory()
  {
    return $this->belongsTo(Inventory::class, 'id_inventory', 'id');
  }

  public function preparer()
  {
    return $this->belongsTo(User::class, 'prepared_by');
  }

  public function checker()
  {
    return $this->belongsTo(User::class, 'prepared_by');
  }
}