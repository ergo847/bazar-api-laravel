<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // lee un archivo json de public json products.json y guardalo en una variable
        $json = file_get_contents('public/json/products.json');

        // decodifica el json
        $data = json_decode($json);

        // recorre el json y guardalo en base de datos
        foreach ($data->products as $obj) {
            $p = \App\Models\Producto::create([
                'title' => $obj->title,
                'description' => $obj->description,
                'brand' => $obj->brand,
                'category' => $obj->category,
                'thumbnail' => $obj->thumbnail,
                'price' => $obj->price,
                'discountPercentage' => $obj->discountPercentage,
                'rating' => $obj->rating,
                'stock' => $obj->stock,
            ]);

            // recorre el json y guardalo en base de datos
            foreach ($obj->images as $image) {
                \App\Models\ImageProducto::create([
                    'producto_id' => $p->id,
                    'url' => $image,
                ]);
            }
        }
    }
}
