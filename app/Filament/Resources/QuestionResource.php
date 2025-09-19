<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('question_set_id')
                    ->relationship('questionSet', 'name')
                    ->required(),
                Forms\Components\Select::make('question_type_id')
                    ->relationship('questionType', 'name')
                    ->required(),
                Forms\Components\TextInput::make('question_number')
                    ->required()
                    ->numeric(),
                 Forms\Components\TextInput::make('digits')
                ->required()
                ->helperText('Enter comma-separated numbers (e.g., 52,35,85,95,55)')
                ->afterStateHydrated(function ($component, $state) {
                    if (is_array($state)) {
                        // Handle both formats during edit
                        $digits = array_map(function($item) {
                            return is_array($item) ? $item['digit'] : $item;
                        }, $state);
                        $component->state(implode(',', $digits));
                    }
                })
                ->dehydrateStateUsing(fn ($state) => array_map('trim', explode(',', $state))),
            
                 // Changed from Repeater to simple Select with array input
                 Forms\Components\Select::make('operators')
                ->required()
                ->multiple()
                ->options([
                    '+' => 'Addition (+)',
                    '-' => 'Subtraction (-)',
                    '' => 'Multiplication ()',
                    '/' => 'Division (/)',
                ])
                ->helperText('Select operators in order')
                ->afterStateHydrated(function ($component, $state) {
                    if (is_array($state)) {
                        // Handle both formats during edit
                        $ops = array_map(function($item) {
                            return is_array($item) ? $item['operator'] : $item;
                        }, $state);
                        $component->state($ops);
                    }
                }),
            
                Forms\Components\TextInput::make('answer')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('time_limit')
                    ->numeric()
                    ->suffix('seconds'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('questionSet.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('questionType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('question_number')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('answer')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('time_limit')
                    ->numeric()
                    ->suffix(' sec')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            RelationManagers\ExamAnswersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}