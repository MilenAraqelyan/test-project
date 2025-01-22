<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Jobs\SendProductCreatedNotification;

class ProductController extends Controller
{
    /**
     * Список продуктов
     */
    public function index()
    {
        // Получаем все продукты (для админа пусть будут все,
        // но можете фильтровать, если нужно)
        $products = Product::orderBy('id', 'desc')->paginate(10);

        return view('products.index', compact('products'));
    }

    /**
     * Форма создания
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Сохранение нового продукта
     */
    public function store(Request $request)
    {
        // Валидация
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:10'],
            'article' => [
                'required',
                'regex:/^[A-Za-z0-9]+$/', // только латинские символы и цифры
                'unique:products,article',
            ],
            'status' => ['required', Rule::in(['available','unavailable'])],
            // Можно добавить валидацию для json-полей, если нужно
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Создаём продукт
        $product = new Product();
        $product->name = $request->input('name');
        $product->article = $request->input('article');
        $product->status = $request->input('status');
        // Дополнительные поля (json)
        $product->data = [
            'color' => $request->input('color'),
            'size' => $request->input('size'),
        ];
        $product->save();

        // Отправка уведомления в очередь
        SendProductCreatedNotification::dispatch($product);

        return redirect()->route('products.index')
            ->with('success', 'Продукт успешно создан!');
    }

    /**
     * Просмотр продукта
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Форма редактирования
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    /**
     * Обновление данных продукта
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Определяем, является ли пользователь админом
        // Роль берём из config('products.role')
        $isAdmin = (config('products.role') === 'admin');

        // Правила валидации
        // Обратите внимание на условие:
        // - article можно менять только, если $isAdmin = true
        $rules = [
            'name' => ['required', 'min:10'],
            'status' => ['required', Rule::in(['available','unavailable'])],
        ];

        // Если пользователь - админ, разрешаем валидировать и изменять артикул
        if ($isAdmin) {
            $rules['article'] = [
                'required',
                'regex:/^[A-Za-z0-9]+$/',
                Rule::unique('products')->ignore($product->id),
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Сохранение
        $product->name = $request->input('name');
        // Если админ - можем обновить article
        if ($isAdmin) {
            $product->article = $request->input('article');
        }
        $product->status = $request->input('status');
        $product->data = [
            'color' => $request->input('color'),
            'size' => $request->input('size'),
        ];

        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Продукт обновлён!');
    }

    /**
     * Удаление
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Продукт удалён!');
    }
}
