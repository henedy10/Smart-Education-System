<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use App\Models\Teacher;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersCount extends StatsOverviewWidget
{
    protected ?string $pollingInterval = '5s';
    protected ?string $description = 'An overview of some analytics.';
    protected ?string $heading = 'Analytics';

    protected function getStats(): array
    {
        return [
            Stat::make('Unique Students',Student::query()->count()),
            Stat::make('Unique Teachers',Teacher::query()->count()),
        ];
    }

}
