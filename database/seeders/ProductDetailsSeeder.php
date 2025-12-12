<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_details')->insert([
            [
                'id' => 1,
                'product_id'=> 1,
                'description' => 'Baju Batik buatan tangan dengan motif tradisional yang elegan.',
            ],
            [
                'id' => 2,
                'product_id'=> 2,
                'description'=>'MacBook Pro M4 14-inch dengan performa tinggi untuk kebutuhan profesional.',
            ],
            [
                'id' => 3,
                'product_id'=> 3,
                'description'=>'Gelang Kulit berkualitas tinggi dengan desain stylish dan tahan lama.',
            ],
            [
                'id' => 4,
                'product_id'=> 4,
                'description'=>'Kertas Binder Loose Leaf cocok untuk keperluan sekolah dan kantor.',
            ],
            [
                'id' => 5,
                'product_id'=> 5,
                'description'=>'Pulpen Gel dengan tinta halus untuk pengalaman menulis yang nyaman.',
            ],
        ]);
    }
}