<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function createProduct(Request $request)
    {
        $product = new Product($request->all());
        if ($product->save() === true) {
            return response()->json($product, 200);
        }
        return response()->json([
            "error" => "Erro ao cadastrar produto"
        ], 400);
    }

    public function getProduct(int $id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    public function getAllProducts()
    {
        $products = Product::all();;
        return response()->json($products);
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);

        if (!$product->exists()) {
            return response()->json(["error" => "Produto não encontrado"], 404);
        }

        $product->delete();

        return response()->json(["success" => "Produto removido com sucesso!"]);
    }

    public function update(int $id, Request $request)
    {
        // Conceito do PUT em Rest, é subistituir
        $product = Product::findOrFail($id);

        // Estamos preenchendo o que veio da request
        // no produtos que selecionamos pelo ID
        $product->fill($request->all());

        if ($product->save()) {
            return response()->json($product, 202);
        }
        return response('Erro ao atualizar', 400);
    }

    public function getProductsByCategory($category)
    {
        return Product::where('category', $category)->get();
    }
}
