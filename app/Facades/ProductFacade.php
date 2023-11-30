<?php

namespace App\Facades;

use App\Jobs\BatchImportProductsJob;
use App\Jobs\ImportProductsJob;
use App\Models\Product;
use Illuminate\Support\Facades\Facade;
use League\Csv\Reader;

class ProductFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'product-importer-facade';
    }

    public static function checkAndDispatch($csvFilePath)
    {
        $csv = Reader::createFromPath(storage_path("app/{$csvFilePath}"), 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        $chunks = array_chunk(iterator_to_array($records), 100);

        foreach ($chunks as $chunk) {
            BatchImportProductsJob::dispatch($chunk)->onQueue('import_products');
        }
    }
}

