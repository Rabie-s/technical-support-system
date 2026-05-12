<?php

namespace App\Filament\Resources\Computers;

use App\Filament\Resources\Computers\Pages\CreateComputer;
use App\Filament\Resources\Computers\Pages\EditComputer;
use App\Filament\Resources\Computers\Pages\ListComputers;
use App\Filament\Resources\Computers\Pages\ViewComputer;
use App\Filament\Resources\Computers\Schemas\ComputerForm;
use App\Filament\Resources\Computers\Schemas\ComputerInfolist;
use App\Filament\Resources\Computers\Tables\ComputersTable;
use App\Models\Computer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ComputerResource extends Resource
{
    protected static ?string $model = Computer::class;

    protected static UnitEnum|string|null $navigationGroup = 'Organization';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'computer_number';

    public static function form(Schema $schema): Schema
    {
        return ComputerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ComputerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ComputersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListComputers::route('/'),
            'create' => CreateComputer::route('/create'),
            'view' => ViewComputer::route('/{record}'),
            'edit' => EditComputer::route('/{record}/edit'),
        ];
    }
}
