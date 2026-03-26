<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Models\User;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Info')
                    ->inlineLabel()
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('email')
                            ->label('Email address'),
                        TextEntry::make('student.class')
                            ->visible(fn (User $record): bool => $record->user_as === 'student')
                            ->label('class'),
                        TextEntry::make('teacher.class')
                            ->visible(fn (User $record): bool => $record->user_as === 'teacher')
                            ->label('class'),
                        TextEntry::make('teacher.subject')
                            ->visible(fn (User $record): bool => $record->user_as === 'teacher')
                            ->label('subject'),
                        TextEntry::make('user_as')
                            ->badge()
                            ->color(function($state){
                                return $state == 'teacher' ? 'warning' : 'success' ;
                            }),
                        TextEntry::make('deleted_at')
                            ->dateTime()
                            ->visible(fn (User $record): bool => $record->trashed()),
                    ])
            ]);
    }
}
