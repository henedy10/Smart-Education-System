<?php

namespace App\Filament\Resources\Teachers\Schemas;

use App\Models\Teacher;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeacherInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Details Of Teacher :')
                ->schema([
                    TextEntry::make('user.name')
                            ->label('Teacher_Name'),
                    TextEntry::make('user.email')
                            ->label('Teacher_Email'),
                    TextEntry::make('subject'),
                    TextEntry::make('class'),

                    TextEntry::make('created_at')
                        ->dateTime()
                        ->placeholder('-'),

                    TextEntry::make('deleted_at')
                        ->dateTime()
                        ->visible(fn (Teacher $record): bool => $record->trashed()),
                ])
                ->inlineLabel()
                ->columnSpanFull()
            ]);
    }
}
