<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $category = Category::get();

        // $i = 31;

        // foreach($category as $cat)
        // {
        //     DB::table('products')->insert([
        //         'id_category' => $cat->id,
        //         'thumbnail' => '',
        //         'brand' => 'brand'.$i,
        //         'code' => 'CODE'.$i,
        //         'name' => 'Product'.$i,
        //         'description' => 'desc....'.$i,
        //         'price' => $i*100,
        //         'stock_quantity' => '1'.$i.'0',
        //         'created_at' => '2022-07-29 16:11:21',
        //         'updated_at' => '2022-07-29 16:11:21',
        //     ]);

        //     $i++;
        // }
    }
}
