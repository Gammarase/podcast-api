<?php

namespace App\Filament\Resources;

use App\Enums\AdminRole;
use App\Filament\Resources\EpisodeResource\Pages;
use App\Models\Episode;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EpisodeResource extends Resource
{
    protected static ?string $model = Episode::class;

    protected static ?string $navigationIcon = 'heroicon-o-musical-note';

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['podcast']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Title')
                    ->required(),
                Textarea::make('description')
                    ->label('Description')
                    ->required(),
                FileUpload::make('image_url')
                    ->label('Image')
                    ->image()
                    ->disk('public')
                    ->directory('images')
                    ->required(),
                TextInput::make('duration')
                    ->label('Duration')
                    ->integer()
                    ->required(),
                TextInput::make('episode_number')
                    ->label('Episode Number')
                    ->integer()
                    ->required(),
                FileUpload::make('file_path')
                    ->label('Audio File')
                    ->disk('public')
                    ->directory('audio')
                    ->acceptedFileTypes(['audio/mpeg'])
                    ->required(),
                Select::make('podcast_id')
                    ->label('Podcast')
                    ->relationship('podcast', 'title', function ($query) {
                        match (auth()->user()->role) {
                            AdminRole::ADMIN => $query,
                            default => $query->where('admin_id', auth()->id()),
                        };
                    })
                    ->searchable()
                    ->required(),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->required(),
                Select::make('guests')
                    ->label('Guests')
                    ->multiple()
                    ->relationship('guests', 'name')
                    ->nullable(),
                Select::make('topics')
                    ->label('Topics')
                    ->multiple()
                    ->relationship('topics', 'name')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('duration')
                    ->label('Duration')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('episode_number')
                    ->label('Episode Number')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->visibleOn(['view']),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function ($query) {
                match (auth()->user()->role) {
                    AdminRole::ADMIN => $query,
                    default => $query->whereHas('podcast', function ($query) {
                        $query->where('admin_id', auth()->id());
                    }),
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
            'index' => Pages\ListEpisodes::route('/'),
            'create' => Pages\CreateEpisode::route('/create'),
            'view' => Pages\ViewEpisode::route('/{record}'),
            'edit' => Pages\EditEpisode::route('/{record}/edit'),
        ];
    }
}
