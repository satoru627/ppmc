<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Liste des formations et services.
     */
    public function index(): View
    {
        $products = Product::latest()->paginate(12);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Formulaire de creation.
     */
    public function create(): View
    {
        return view('admin.products.form', ['product' => new Product()]);
    }

    /**
     * Enregistre un produit.
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['title']);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produit cree avec succes.');
    }

    /**
     * Formulaire de modification.
     */
    public function edit(Product $product): View
    {
        return view('admin.products.form', compact('product'));
    }

    /**
     * Met a jour un produit.
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $data = $this->validatedData($request, $product);
        $data['slug'] = $this->uniqueSlug($data['title'], $product->id);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produit mis a jour.');
    }

    /**
     * Supprime le produit si possible, sinon le desactive.
     */
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->orders()->exists()) {
            $product->update(['is_active' => false]);

            return back()->with('success', 'Produit desactive car il possede deja des commandes.');
        }

        if ($product->file_path) {
            Storage::disk('local')->delete($product->file_path);
        }

        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return back()->with('success', 'Produit supprime.');
    }

    /**
     * Prepare les donnees valides et les fichiers envoyes.
     */
    private function validatedData(ProductRequest $request, ?Product $product = null): array
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');

        unset($data['product_file'], $data['image']);

        if ($request->hasFile('product_file')) {
            if ($product?->file_path) {
                Storage::disk('local')->delete($product->file_path);
            }

            $data['file_path'] = $request->file('product_file')->store('products', 'local');
        }

        if ($request->hasFile('image')) {
            if ($product?->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products/images', 'public');
        }

        return $data;
    }

    /**
     * Genere un slug unique a partir du titre.
     */
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 2;

        while (Product::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
