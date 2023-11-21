<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // API
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
}
