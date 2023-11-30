<?php

namespace App\Listeners;

use App\Events\ProductAddedEvent;
use App\Mail\ProductExistanceNotification;
use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CheckProductExistance
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ProductAddedEvent $event)
    {
        // log the event data
        Log::info('Event data:', ['data' => $event->product]);

        $product = $event->product;

        // get product
        $existingProduct = Product::where('sku', $product['SKU'])->first();

        if ($existingProduct) {
            $this->sendProductExistenceNotification($product, $existingProduct);
        }
    }

    protected function sendProductExistenceNotification($newProduct, $existingProduct)
    {
        Mail::send('emails.product_existence_notification', ['newProduct' => $newProduct, 'existingProduct' => $existingProduct], function($message) {
            $message->to(env('MAIL_TO_ADDRESS'));
            $message->from(env('MAIL_FROM_ADDRESS'));
            $message->subject('Product Existence Notification');
        });
    }
}
