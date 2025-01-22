<?php

namespace App\Jobs;

use App\Models\Product;
use App\Notifications\ProductCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendProductCreatedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;

    /**
     * Create a new job instance.
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        // Отправляем уведомление на email, указанный в config('products.email')
        $email = config('products.email');

        // Можно отправлять уведомление любому "Notifiable", для простоты
        // используем анонимный объект/или модель User, если есть
        Notification::route('mail', $email)
            ->notify(new ProductCreated($this->product));
    }
}
