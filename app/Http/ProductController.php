<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = \App\Models\Category::all(); // Получаем все категории
    
        // Создаем запрос для фильтрации товаров
        $query = \App\Models\Product::query();
    
        // Фильтр по категории
        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }
    
        // Фильтр по минимальной цене
        if ($request->has('price_min') && !empty($request->price_min)) {
            $query->where('price', '>=', $request->price_min);
        }
    
        // Фильтр по максимальной цене
        if ($request->has('price_max') && !empty($request->price_max)) {
            $query->where('price', '<=', $request->price_max);
        }
    
        // Фильтр по названию (поиск)
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'LIKE', '%' . $request->search . '%');
        }
    
        // Фильтр "Только товары со скидками"
        if ($request->has('discounted')) {
            $query->where('discount', '>', 0)
                  ->where(function ($query) {
                      $query->whereNull('discount_start')
                            ->orWhere('discount_start', '<=', now());
                  })
                  ->where(function ($query) {
                      $query->whereNull('discount_end')
                            ->orWhere('discount_end', '>=', now());
                  });
        }        
        

        // Сортировка товаров
        if ($request->has('sort_by')) {
            switch ($request->sort_by) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name_asc':
                    query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
            }
        }
    
        $products = $query->get(); // Выполняем запрос и получаем товары
        $products = $query->paginate(10);
        return view('products.index', compact('products', 'categories'));
    }
    
    
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all(); // Получаем все категории
        return view('products.create', compact('categories'));
    }
    

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (!auth()->user()->isAdmin() && !auth()->user()->isEmployee()) {
            return abort(403, 'Доступ запрещён');
        }    

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'discount' => 'nullable|integer|min:0|max:100',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
        ]);
    
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->discount = $request->discount ?? 0;
        $product->discount_start = $request->discount_start ? Carbon::parse($request->discount_start) : null;
        $product->discount_end = $request->discount_end ? Carbon::parse($request->discount_end) : null;
        $product->stock = $request->stock ?? 0; // ✅ Добавляем stock (если не указано, ставим 0)
        $product->save();
        
    
        return redirect()->route('products.index')->with('success', 'Товар добавлен!');

        dd($request->all());

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product')); // Передаем товар в шаблон
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = \App\Models\Category::all(); // Получаем все категории
        return view('products.edit', compact('product', 'categories'));
    }
    
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {

        if (!auth()->user()->isAdmin() && !auth()->user()->isEmployee()) {
            return abort(403, 'Доступ запрещён');
        }
    
        $request->validate([
            'name' => 'required|max:50|unique:products,name,' . $product->id,
            'description' => 'nullable',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|max:2048',
            'discount' => 'nullable|integer|min:0|max:100',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
        ]);
    
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category_id = $request->category_id;
        $product->discount = $request->discount;
        $product->discount_start = $request->discount_start;
        $product->discount_end = $request->discount_end;
        $product->save();

    
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        if ($request->has('discounted')) {
            $query->where('discount', '>', 0)
                  ->where('discount_start', '<=', now())
                  ->where('discount_end', '>=', now());
        }
        
    
        $product->update($request->all());

        return redirect()->route('admin.products')->with('success', 'Товар обновлён.');
    }
    
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (!auth()->user()->isAdmin()) {
            return abort(403, 'Доступ запрещён');
        }
    
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Товар удалён.');
    }
    

    public function discounted()
    {
        $products = Product::where('discount', '>', 0)
            ->where(function ($query) {
                $query->whereNull('discount_start')
                      ->orWhere('discount_start', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('discount_end')
                      ->orWhere('discount_end', '>=', now());
            })
            ->paginate(10);
    
        return view('products.discounted', compact('products'));
    }

    public function adminIndex()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }
    
    
}



