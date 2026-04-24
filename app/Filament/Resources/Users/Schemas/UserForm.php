<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('User Info')
                    ->schema([
                        TextInput::make('name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->hidden(fn ($operation) => $operation === 'edit')
                            ->required(),
                        Select::make('user_as')
                            ->options([
                                'teacher' => 'Teacher',
                                'student' => 'Student',
                            ])
                            ->required()
                            ->reactive(),
                    ]),
                Fieldset::make('Student Info')
                    ->relationship('student')
                    ->schema([
                        TextInput::make('class'),
                    ])
                    ->visible(fn (Get $get): bool => $get('user_as') === 'student'),

                Fieldset::make('Teacher Info')
                    ->relationship('teacher')
                    ->schema([
                        TextInput::make('class'),
                        TextInput::make('subject'),
                    ])
                    ->visible(fn (Get $get): bool => $get('user_as') === 'teacher'),
            ]);
    }
}
