<?php

namespace App\Filament\Exports;

use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class ProductStockExport
{
    public static function make(): ExcelExport
    {
        return ExcelExport::make()
            ->withFilename('stock-' . now()->format('Y-m-d'))
            ->withColumns([
                Column::make('name'),
                Column::make('itemType.name')->heading('Item Type'),
                Column::make('stock'),
                Column::make('brand'),
                Column::make('unit'),
            ]);
    }
}