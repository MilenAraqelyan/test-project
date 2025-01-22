<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\Product;

class ProductCreated extends Notification
{
    use Queueable;

    protected $product;

    /**
     * Передаем продукт в конструктор
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Получатели уведомления (mail, slack и т.д.)
     * Для примера только mail-канал
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Формирование сообщения на email
     */
    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Новый продукт создан')
            ->line('Создан продукт: ' . $this->product->name)
            ->line('Артикул: ' . $this->product->article)
            ->line('Спасибо за использование нашего приложения!');
    }
}
