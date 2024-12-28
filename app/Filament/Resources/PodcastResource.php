<?php

namespace App\Filament\Resources;

use App\Enums\AdminRole;
use App\Filament\Resources\PodcastResource\Pages;
use App\Filament\Resources\PodcastResource\RelationManagers\EpisodesRelationManager;
use App\Models\Podcast;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PodcastResource extends Resource
{
    protected static ?string $model = Podcast::class;

    protected static ?string $navigationIcon = 'heroicon-o-microphone';

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
                    ->directory('podcasts')
                    ->required(),
                Select::make('language')
                    ->label('Language')
                    ->required()
                    ->options(
                        [
                            'ua' => 'Ukrainian',
                            'en' => 'English',
                            'es' => 'Spanish',
                            'fr' => 'French',
                            'de' => 'German',
                            'it' => 'Italian',
                            'zh' => 'Chinese',
                            'ja' => 'Japanese',
                            'ko' => 'Korean',
                        ]),
                Checkbox::make('featured')
                    ->label('Featured')
                    ->default(false)
                    ->disabled(function () {
                        return auth()->user()->role !== AdminRole::ADMIN;
                    }),
                Select::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name')
                    ->required(),
                Select::make('admin_id')
                    ->label('Author')
                    ->relationship('admin', 'name', function ($query) {
                        match (auth()->user()->role) {
                            AdminRole::ADMIN => $query,
                            default => $query->where('id', auth()->id()),
                        };
                    })
                    ->required(),
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
                    ->label('Name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->sortable()
                    ->searchable()
                    ->visibleOn(['view']),
                SelectColumn::make('language')
                    ->label('Language')
                    ->sortable()
                    ->options(
                        [
                            'ua' => 'Ukrainian',
                            'en' => 'English',
                            'es' => 'Spanish',
                            'fr' => 'French',
                            'de' => 'German',
                            'it' => 'Italian',
                            'zh' => 'Chinese',
                            'ja' => 'Japanese',
                            'ko' => 'Korean',
                        ])
                    ->disabled()
                    ->searchable(),
                CheckboxColumn::make('featured')
                    ->label('Featured')
                    ->sortable()
                    ->disabled(function () {
                        return auth()->user()->role !== AdminRole::ADMIN;
                    })
                    ->searchable(),
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
                    default => $query->where('admin_id', auth()->id()),
                };
            });
    }

    public static function getRelations(): array
    {
        return [
            EpisodesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPodcasts::route('/'),
            'create' => Pages\CreatePodcast::route('/create'),
            'view' => Pages\ViewPodcast::route('/{record}'),
            'edit' => Pages\EditPodcast::route('/{record}/edit'),
        ];
    }
}
