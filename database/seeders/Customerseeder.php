<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
  public function run()
  {
    $customers = [
      'PT. ASTRA DAIHATSU MOTOR',
      'PT. HINO MOTORS MANUFACTURING INDONESIA',
      'PT. HONDA PROSPECT MOTOR',
      'PT. ISUZU ASTRA MOTOR INDONESIA',
      'PT. KRAMA YUDHA TIGA BERLIANMOTORS',
      'PT. MITSUBISHI MOTORS KRAMA YUDHA INDONESIA',
      'PT. MITSUBISHI MOTORS KRAMA YUDHA SALES INDONESIA',
      'PT. SUZUKI INDOMOBIL SALES',
      'PT. YAMAHA MUSIC MANUFACTURING INDONESIA',
      'PT. SWAKARYA INSAN MANDIRI',
      'PT. TOYOTA MOTOR MANUFACTURING INDONESIA',
      'PT. HYUNDAI MOTORS MANUFACTURING INDONESIA',
      'PT. INOAC POLYTECH INDONESIA',
      'PT. DENSO INDONESIA',
      'PT. IRC INOAC INDONESIA',
      'PT. VALEO AC INDONESIA',
      'PT. TONKAI RUBBER INDONESIA',
    ];
    $usernames = [
      'ADM-KAP',
      'ADM-KEP',
      'ADM-SAP',
      'ADM-SEP',
      'ADM-SPD',
      'ASMO-DMIA',
      'DENSO',
      'GMK',
      'HAC',
      'HINO',
      'HINO-SPD',
      'HMMI',
      'HPM',
      'HPM-SPD LOKAL',
      'IAMI',
      'IPI',
      'IRC',
      'KTB',
      'KTB-SPD',
      'MAH SING',
      'MMKI',
      'MMKI-SPD',
      'NAFUCO',
      'NAGASSE',
      'NISSEN',
      'PBI',
      'SIM',
      'SIM-SPD',
      'SMI',
      'TMMIN',
      'TMMIN-POQ',
      'TRID',
      'VALEO',
      'YMPI',
    ];

    foreach ($customers as $index => $customer) {
      Customer::create([
        'name' => $customer,
        'username' => $usernames[$index]
      ]);
    }
  }
}
