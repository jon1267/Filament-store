<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
//use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make('Product Details')
                        ->schema([
                            TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(), // time 16:15 Less 5 (4-ECommerce)
                            TextInput::make('slug')
                                ->required()
                                ->maxLength(255)
                                ->disabled(),
                            MarkdownEditor::make('description')
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('products')
                        ])->columns(2),

                    Forms\Components\Section::make('Images')
                        ->schema([
                            FileUpload::make('images')
                            ->multiple()
                            ->directory('products')
                            ->maxFiles(5)
                            ->reorderable()
                        ]),
                ])->columnSpan(2),

                Forms\Components\Group::make()->schema([

                    Forms\Components\Section::make('Pricing')
                        ->schema([
                            TextInput::make('price')
                            ->numeric()
                            ->required()
                            ->prefix('EUR')
                        ]),

                    Forms\Components\Section::make('Category & Brand')
                        ->schema([
                            Select::make('category_id')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->relationship('category', 'name'),

                            Select::make('brand_id')
                                ->required()
                                ->searchable()
                                ->preload()
                                ->relationship('brand', 'name'),
                        ]),

                    Forms\Components\Section::make('Status')
                        ->schema([
                            Forms\Components\Toggle::make('in_stock')
                                ->label('In Stock')
                                ->required()
                                ->default(true),
                            Forms\Components\Toggle::make('is_active')
                                ->label('Is Active')
                                ->required()
                                ->default(true),
                            Forms\Components\Toggle::make('is_featured')
                                ->label('Is Featured')
                                ->required(),
                            Forms\Components\Toggle::make('on_sale')
                                ->label('On Sale')
                                ->required(),
                        ]),

                ])->columnSpan(1)

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
