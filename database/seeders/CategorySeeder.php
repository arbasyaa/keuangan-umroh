<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['name' => 'Paspor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pembelian', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
