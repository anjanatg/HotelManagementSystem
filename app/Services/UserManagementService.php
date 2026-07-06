<?php

namespace App\Services;

use App\Models\UserManagement;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserManagementService
{
    /**
     * Validation rules for creating a user.
     */
    protected function storeRules(): array
    {
        return [
            'name'   => 'required|unique:user_management,name',
            'email'  => 'required|email|unique:user_management,email',
            'phone'  => 'required|numeric|digits:10',
            'role'   => 'required',
            'status' => 'required',
        ];
    }

    /**
     * Validation rules for updating a user (excludes current record from unique checks).
     */
    protected function updateRules(int $id): array
    {
        return [
            'name'   => 'required|unique:user_management,name,' . $id,
            'email'  => 'required|email|unique:user_management,email,' . $id,
            'phone'  => 'required|numeric|digits:10',
            'role'   => 'required',
            'status' => 'required',
        ];
    }

    public function getAll()
    {
        return UserManagement::query();;
    }

    public function find(int $id): UserManagement
    {
        return UserManagement::findOrFail($id);
    }

    /**
     * Check whether a given name already exists (used for AJAX inline validation).
     */
    public function nameExists(?string $name): bool
    {
        if (!$name) {
            return false;
        }

        return UserManagement::where('name', $name)->exists();
    }

    /**
     * Validate and create a new user.
     *
     * @throws ValidationException
     */
    public function create(array $data): UserManagement
    {
        $validated = Validator::make($data, $this->storeRules())->validate();

        return UserManagement::create($validated);
    }

    /**
     * Validate and update an existing user.
     *
     * @throws ValidationException
     */
    public function update(int $id, array $data): UserManagement
    {
        $user = $this->find($id);

        $validated = Validator::make($data, $this->updateRules($id))->validate();

        $user->update($validated);

        return $user;
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }
}