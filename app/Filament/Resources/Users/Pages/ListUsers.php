<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->emptyStateHeading('No users yet')
            ->emptyStateIcon('heroicon-o-users');
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All users'),
            'students' => Tab::make('Students')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_as', 'student')),
            'teachers' => Tab::make('Teachers')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('user_as', 'teacher')),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
