<?php

namespace App\Filament\Resources\Products\Pages;

use App\Filament\Resources\Products\ProductResource;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Product info')->schema([
                ImageEntry::make('image')
                    ->disk('public')
                    ->hiddenLabel()
                    ->height(120)
                    ->visible(fn($record) => filled($record->image)),

                TextEntry::make('name'),

                TextEntry::make('brand')
                    ->placeholder('—'),

                TextEntry::make('itemType.name')
                    ->label('Item type')
                    ->badge()
                    ->color('info'),

                TextEntry::make('unit'),

                TextEntry::make('notes')
                    ->placeholder('—')
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('Stock')->schema([
                TextEntry::make('stock')
                    ->label('Current stock')
                    ->suffix(fn($record) => ' ' . $record->unit->value)
                    ->weight('bold')
                    ->color(
                        fn($record) => $record->stock <= $record->min_qty
                            ? 'danger'
                            : 'success'
                    ),

                TextEntry::make('min_qty')
                    ->label('Min quantity')
                    ->suffix(fn($record) => ' ' . $record->unit->value),

                TextEntry::make('stock_status')
                    ->label('Status')
                    ->getStateUsing(
                        fn($record) => $record->stock <= $record->min_qty
                            ? 'Low stock'
                            : 'Sufficient'
                    )
                    ->badge()
                    ->color(
                        fn($record) => $record->stock <= $record->min_qty
                            ? 'danger'
                            : 'success'
                    ),

                TextEntry::make('total_purchased')
                    ->label('Total purchased')
                    ->getStateUsing(fn($record) => $record->totalPurchased())
                    ->suffix(fn($record) => ' ' . $record->unit->value),

                TextEntry::make('total_used')
                    ->label('Total used')
                    ->getStateUsing(fn($record) => $record->totalUsed())
                    ->suffix(fn($record) => ' ' . $record->unit->value),

                TextEntry::make('total_movements')
                    ->label('Total movements')
                    ->getStateUsing(fn($record) => $record->transactions()->count()),
            ])->columns(3),

        ]);
    }
}
