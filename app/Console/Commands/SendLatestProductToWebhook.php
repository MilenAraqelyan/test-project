<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class SendLatestProductToWebhook extends Command
{
    protected $signature = 'products:send-latest-to-webhook';
    protected $description = 'Отправляет POST-запрос с информацией о продукте с наибольшим ID на указанный в конфиге URL';

    public function handle()
    {
        $webhookUrl = config('products.webhook');

        // Получаем продукт с максимальным ID
        $latestProduct = Product::orderBy('id', 'desc')->first();

        if (!$latestProduct) {
            $this->info('Нет продуктов для отправки.');
            return 0;
        }

        // Формируем данные для отправки
        $data = [
            'id' => $latestProduct->id,
            'article' => $latestProduct->article,
            'name' => $latestProduct->name,
            'status' => $latestProduct->status,
            'data' => $latestProduct->data,
        ];

        // Отправляем POST-запрос
        try {
            $response = Http::post($webhookUrl, $data);
            $this->info('Запрос отправлен. Ответ сервера: ' . $response->body());
        } catch (\Exception $e) {
            $this->error('Ошибка при отправке: ' . $e->getMessage());
        }

        return 0;
    }
}
