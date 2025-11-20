<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(9); 
        
        $userFavorites = [];
        if (auth()->check()) {
            $userFavorites = auth()->user()->favorites()->pluck('product_id')->flip();
        }

        return view('products.index', compact('products', 'userFavorites'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'endereco' => 'required',
            'proprietario' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Guarda na pasta 'product_images' dentro de 'storage/app/public'
            $validated['image'] = $request->file('image')->store('product_images', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso!');
    }

    public function show($id) 
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
        // Se usar Route Model Binding: return view('products.show', compact('product'));
    }

    public function edit(Product $product) // Usando Route Model Binding
    {
        // Retorna a view de edição, passando o produto encontrado
        return view('products.edit', compact('product')); // Certifique-se que a view 'products.edit' existe
    }

    public function update(Request $request, Product $product) // Usando Route Model Binding
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'endereco' => 'required',
            'proprietario' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Lógica para lidar com a atualização da imagem
        if ($request->hasFile('image')) {
            // 1. Remove a imagem antiga se existir
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            // 2. Guarda a nova imagem
            $validatedData['image'] = $request->file('image')->store('product_images', 'public');
        }

        $product->update($validatedData);

        // Redireciona de volta para a lista com mensagem de sucesso
        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso!');
    }
    public function destroy(Product $product) // Usando Route Model Binding
    {
        // 1. Remove a imagem do storage se ela existir
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // 2. Deleta o registo do produto do banco de dados
        $product->delete();

        // 3. Redireciona de volta para a lista com mensagem de sucesso
        return redirect()->route('products.index')->with('success', 'Produto removido com sucesso!');
    }
}