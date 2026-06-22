<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ItemService
{
    /**
     * Validation rules for creating an item.
     */
    protected function storeRules(): array
    {
        return [
            'item_name' => 'required|unique:items,item_name',
            'unit'      => 'required',
        ];
    }

    /**
     * Validation rules for updating an item (excludes current record from unique check).
     */
    protected function updateRules(int $id): array
    {
        return [
            'item_name' => 'required|unique:items,item_name,' . $id,
            'unit'      => 'required',
        ];
    }

    public function getAll()
    {
        return Item::all();
    }

    public function find(int $id): Item
    {
        return Item::findOrFail($id);
    }

    /**
     * Validate and create a new item.
     *
     * @throws ValidationException
     */
    public function create(array $data): Item
    {
        $validated = Validator::make($data, $this->storeRules())->validate();

        return Item::create($validated);
    }

    /**
     * Validate and update an existing item.
     *
     * @throws ValidationException
     */
    public function update(int $id, array $data): Item
    {
        $item = $this->find($id);

        $validated = Validator::make($data, $this->updateRules($id))->validate();

        $item->update($validated);

        return $item;
    }

    public function delete(int $id): void
    {
        $this->find($id)->delete();
    }
}