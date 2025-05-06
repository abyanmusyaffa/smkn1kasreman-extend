<?php

namespace App\Filament\Resources\AlumniResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Models\Alumni;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\AlumniResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAlumni extends CreateRecord
{
    protected static string $resource = AlumniResource::class;
}
