<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function __construct(Product $product, Category $category)
    {
        $this->product = $product;
        $this->category = $category;
    }

    /**
     * Retorna as categorias associadas a um produto
     */
    public function categories($idProduct)
    {
        $product = $this->product->find($idProduct);

        if(!$product) {
            return redirect()->back();
        }

        $categories = $product->categories()->paginate();

        return view('admin.pages.products.categories.categories', compact('product', 'categories'));
    }

    /**
     * Retorna os produtos associados a uma categoria
     */
    public function products($idCategory)
    {
        $category = $this->category->find($idCategory);

        if(!$category) {
            return redirect()->back();
        }

        $products = $category->products()->paginate();

        return view('admin.pages.categories.products.products', compact('category', 'products'));
    }

    /**
     * Recupera as categorias não associadas a um produto
     */
    public function categoriesAvailable(Request $request, $idProduct)
    {
        
        if(!$product = $this->product->find($idProduct)) {
            return redirect()->back();
        }

        $filters = $request->except('_token');

        $categories = $product->categoriesAvailable($request->filter);

        return view('admin.pages.products.categories.available', compact('product', 'filters', 'categories'));
    }

    /**
     * Associa uma ou mais categorias a um produto
     */
    public function attachCategoriesProduct(Request $request, $idProduct)
    {
        if (!$product = $this->product->find($idProduct)) {
            return redirect()->back();
        }

        if(!$request->categories || count($request->categories) == 0) {
            return redirect()->back()->with('info', 'Você precisa selecionar uma categoria.');
        }

        //associa a cateria ao produto
        $product->categories()->attach($request->categories);

        return redirect()->route('products.categories', $product->id);
    }

    /**
     * Desvincula a categoria de um produto
     */
    public function detachCategoryProduct($idProduct, $idCategory)
    {
        $product = $this->product->find($idProduct);
        $category = $this->category->find($idCategory);

        if(!$product || !$category) {
            return redirect()->back();
        }

        $product->categories()->detach($category);

        return redirect()->route('products.categories', $product->id);
    }
}
