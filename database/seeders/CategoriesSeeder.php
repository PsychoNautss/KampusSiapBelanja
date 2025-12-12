<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id'=>1, 'name'=>'Pakaian', 'created_at'=>now()],
            ['id'=>2, 'name'=>'Elektronik', 'created_at'=>now()],
            ['id'=>3, 'name'=>'Aksesoris', 'created_at'=>now()],
            ['id'=>4, 'name'=>'Buku dan Alat Tulis', 'created_at'=>now()],
            ['id'=>5, 'name'=>'Kesehatan', 'created_at'=>now()],
        ]);
    }
}
