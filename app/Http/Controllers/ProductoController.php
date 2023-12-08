<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // API

    // index
    public function index(Request $request, Producto $producto = null)
    {
        if ($producto) {
            // return json response
            return response()->json([
                'success' => true,
                'message' => 'Producto encontrado',
                'data' => $producto->detalle(),
            ], 200);
        } else {
            // get all productos buscados por un parametro dado desde url llamado 'search' por title, description, brand, category y paginalos de 10 en 10
            $productos = Producto::query();

            if ($request->has('search')) {
                $productos->where(function ($query) use ($request) {
                    $query->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('description', 'like', '%' . $request->search . '%')
                        ->orWhere('brand', 'like', '%' . $request->search . '%')
                        ->orWhere('category', 'like', '%' . $request->search . '%');
                });
            }

            $productos = $productos->paginate(9)->appends($request->query());

            // return json response
            return response()->json([
                'success' => true,
                'message' => 'Lista de productos',
                'request' => $request->all(),
                'data' => $productos,
            ], 200);
        }
    }

    // create
    public function create(Request $request)
    {
        // validate request
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'brand' => 'required|string',
            'category' => 'required|string',
            'thumbnail' => 'required|string',
            'price' => 'required|numeric',
            'discountPercentage' => 'required|numeric',
            'rating' => 'required|numeric',
            'stock' => 'required|numeric',
            'images' => 'required|array',
        ]);

        // create producto
        $producto = Producto::create([
            'title' => $request->title,
            'description' => $request->description,
            'brand' => $request->brand,
            'category' => $request->category,
            'thumbnail' => $request->thumbnail,
            'price' => $request->price,
            'discountPercentage' => $request->discountPercentage,
            'rating' => $request->rating,
            'stock' => $request->stock,
        ]);

        // upload images
        foreach ($request->images as $image) {
            /* crea si image no esta vacio */
            if ($image) {
                $producto->images()->create([
                    'url' => $image,
                ]);
            }
        }

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Producto creado',
            'data' => $producto->detalle(),
        ], 201);
    }

    // update
    public function update(Request $request, Producto $producto)
    {
        // validate request
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'brand' => 'required|string',
            'category' => 'required|string',
            'thumbnail' => 'required|string',
            'price' => 'required|numeric',
            'discountPercentage' => 'required|numeric',
            'rating' => 'required|numeric',
            'stock' => 'required|numeric',
            'images' => 'required|array',
        ]);

        // update producto
        $producto->update([
            'title' => $request->title,
            'description' => $request->description,
            'brand' => $request->brand,
            'category' => $request->category,
            'thumbnail' => $request->thumbnail,
            'price' => $request->price,
            'discountPercentage' => $request->discountPercentage,
            'rating' => $request->rating,
            'stock' => $request->stock,
        ]);

        // upload new images an delete past
        $producto->images()->delete();

        foreach ($request->images as $image) {
            $producto->images()->create([
                'url' => $image,
            ]);
        }

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Producto actualizado',
            'data' => $producto->detalle(),
        ], 200);
    }

    // delete
    public function delete(Producto $producto)
    {
        // borrar imagenes del producto
        $producto->images()->delete();
        // delete producto
        $producto->delete();

        // return json response
        return response()->json([
            'success' => true,
            'message' => 'Producto eliminado',
        ], 200);
    }
}
