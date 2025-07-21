<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    // из реквеста удаляем поле password, если оно не заполнено
    // чтоб не кидало ошибку на пароле при редактировании
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if ($data['password'] === null ) {
            unset($data['password']);
        }

        return $data;
    }
}
