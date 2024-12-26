<?php

namespace App\Filament\Resources;

use App\Enums\AdminRole;
use App\Filament\Resources\AdminResource\Pages;
use App\Models\Admin;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->placeholder('John Doe'),
                TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->placeholder('example@mail.com'),
                TextInput::make('password')
                    ->label('Password')
                    ->required()
                    ->placeholder('********')
                    ->password()
                    ->autocomplete('new-password')
                    ->visibleOn(['create']),
                Select::make('role')
                    ->label('Role')
                    ->options(AdminRole::getOptions())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                SelectColumn::make('role')
                    ->label('Role')
                    ->options(AdminRole::getOptions())
                    ->sortable()
                    ->disabled(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function (Builder $query) {
                match (auth()->user()->role) {
                    AdminRole::ADMIN => $query,
                    default => $query->where('id', auth()->id()),
                };
            });
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
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
            'view' => Pages\ViewAdmin::route('/{record}'),
        ];
    }
}
