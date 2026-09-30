<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! auth()->user()->isSuperAdmin()) {
            $data['hospital_id'] = auth()->user()->hospital_id;
        }
        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->syncRoles($this->form->getState()['roles'] ?? []);
    }
}
