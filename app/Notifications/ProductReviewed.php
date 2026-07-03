<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProductReviewed extends Notification
{
    use Queueable;

    private $reviewerName;
    private $productName;

    public function __construct($reviewerName, $productName)
    {
        $this->reviewerName = $reviewerName;
        $this->productName = $productName;
    }

    public function via(object $notifiable): array
    {
        return ['database']; 
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => "⭐ Your listing '{$this->productName}' received a new 5-star review from {$this->reviewerName}!",
            'time' => now()->format('M d, h:i A')
        ];
    }
}