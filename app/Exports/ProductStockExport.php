<?php

namespace App\Exports;

use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ProductStockExport
{
    public static function make(): ExcelExport
    {
        return ExcelExport::make()
            ->withFilename('stock-'.now()->format('Y-m-d'))
            ->withColumns([
                Column::make('name'),
                Column::make('itemType.name')->heading('Item Type'),
                Column::make('stock'),
                Column::make('brand'),
                Column::make('unit'),
            ]);
    }
}
