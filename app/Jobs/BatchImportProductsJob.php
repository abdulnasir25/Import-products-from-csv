<?php

namespace App\Jobs;

use App\Events\ProductAddedEvent;
use App\Listeners\CheckProductExistance;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class BatchImportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $products;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($products)
    {
        $this->products = $products;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->products as $productData) {
            // generate event
            event(new ProductAddedEvent($productData));

            // Insert product into the database
            Product::create([
                'title' => $productData['Title'],
                'description' => $productData['Description'],
                'sku' => $productData['SKU'],
                'type' => $productData['Type'],
                'cost_price' => !empty($productData['Price']) ? $productData['Price'] : 0,
                'status' => $productData['Published'],
            ]);
        }
    }
}
