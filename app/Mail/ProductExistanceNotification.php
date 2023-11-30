<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductExistanceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $newProduct;
    public $existingProduct;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Product $newProduct, Product $existingProduct)
    {
        $this->newProduct = $newProduct;
        $this->existingProduct = $existingProduct;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Product Existence Notification')
            ->view('emails.product_existence_notification');
    }
}
