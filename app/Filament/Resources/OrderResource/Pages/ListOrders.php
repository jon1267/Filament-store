<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderResource\Widgets\OrderStats::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'new' => Tab::make('New')->query(fn ($query) => $query->where('status', 'new')),
            'processing' => Tab::make('Processing')->query(fn ($query) => $query->where('status', 'processing')),
            'shipped' => Tab::make('Shipped')->query(fn ($query) => $query->where('status', 'shipped')),
            'delivered' => Tab::make('Delivered')->query(fn ($query) => $query->where('status', 'delivered')),
            'canceled' => Tab::make('Canceled')->query(fn ($query) => $query->where('status', 'canceled')),
            // time: 00:01 Less 9 (8-E)
        ];
    }

    /* или getHeaderWidgets() или этот
     protected function getFooterWidgets(): array
    {
        return [
            OrderResource\Widgets\OrderStats::class,
        ];
    }*/
}
