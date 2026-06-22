<?php

namespace App\Services;

use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SupplierService
{
    /**
     * Validation rules for creating a supplier.
     */
    protected function storeRules(): array
    {
        return [
            'name'    => 'required|unique:suppliers,name',
            'email'   => 'required|email|unique:suppliers,email',
            'phone'   => 'required|numeric|digits:10',
            'company' => 'required',
            'address' => 'required',
            'status'  => 'required',
        ];
    }

    /**
     * Validation rules for updating a supplier (excludes current record from unique checks).
     */
    protected function updateRules(int $id): array
    {
        return [
            'name'    => 'required|unique:suppliers,name,' . $id,
            'email'   => 'required|email|unique:suppliers,email,' . $id,
            'phone'   => 'required|numeric|digits:10',
            'company' => 'required',
            'address' => 'required',
            'status'  => 'required',
        ];
    }

    public function getAll()
    {
        return Supplier::all();
    }

    public function find(int $id): Supplier
    {
        return Supplier::findOrFail($id);
    }

    /**
     * Validate and create a new supplier.
     *
     * @throws ValidationException
     */
    public function create(array $data): Supplier
    {
        $validated = Validator::make($data, $this->storeRules())->validate();

        return Supplier::create($validated);
    }

    /**
     * Validate and update an existing supplier.
     *
     * @throws ValidationException
     */
    public function update(int $id, array $data): Supplier
    {
        $supplier = $this->find($id);

        $validated = Validator::make($data, $this->updateRules($id))->validate();

        $supplier->update($validated);

        return $supplier;
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }
}