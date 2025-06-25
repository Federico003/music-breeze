<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Month;
use Illuminate\Support\Facades\DB;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('month')->insert([
            ['name' => 'Gennaio'],
            ['name' => 'Febbraio'],
            ['name' => 'Marzo'],
            ['name' => 'Aprile'],
            ['name' => 'Maggio'],
            ['name' => 'Giugno'],
            ['name' => 'Luglio'],
            ['name' => 'Agosto'],
            ['name' => 'Settembre'],
            ['name' => 'Ottobre'],
            ['name' => 'Novembre'],
            ['name' => 'Dicembre'],
        ]);
    }
}
