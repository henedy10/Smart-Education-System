<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Details Of Student :')
                ->schema([
                    TextEntry::make('user.name')
                        ->label('Student_Name'),
                    TextEntry::make('user.email')
                        ->label('Student_Email'),
                    TextEntry::make('class'),
                    TextEntry::make('created_at')
                        ->dateTime()
                        ->placeholder('-')
                ])
                ->inlineLabel()
                ->columnSpanFull()
            ]);
    }
}
