<?php

namespace App\Filament\Resources\ServiceCards;

use App\Filament\Resources\ServiceCards\Pages\CreateServiceCard;
use App\Filament\Resources\ServiceCards\Pages\EditServiceCard;
use App\Filament\Resources\ServiceCards\Pages\ListServiceCards;
use App\Filament\Resources\ServiceCards\Schemas\ServiceCardForm;
use App\Filament\Resources\ServiceCards\Tables\ServiceCardsTable;
use App\Models\ServiceCard;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServiceCardResource extends Resource
{
    protected static ?string $model = ServiceCard::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ServiceCardForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ServiceCardsTable::configure($table);
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
            'index' => ListServiceCards::route('/'),
            'create' => CreateServiceCard::route('/create'),
            'edit' => EditServiceCard::route('/{record}/edit'),
        ];
    }
}
