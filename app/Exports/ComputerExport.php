<?php

namespace App\Exports;

use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ComputerExport
{
    public static function make(): ExcelExport
    {
        return ExcelExport::make()
            ->withFilename('computers-'.now()->format('Y-m-d'))
            ->withColumns([
                Column::make('department.name')->heading('Department'),
                Column::make('ip_address')->heading('IP Address'),
                Column::make('computer_number')->heading('Computer Number'),
            ]);
    }
}
