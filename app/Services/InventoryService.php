<?php

namespace App\Services;

use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InventoryService
{
    /**
     * Validation rules for adding stock (creating an inventory record).
     */
    protected function storeRules(): array
    {
        return [
            'item_id'             => 'required|exists:items,id',
            'quantity'            => 'required|numeric|min:0',
            'minimum_stock_level' => 'required|numeric|min:0',
        ];
    }

    /**
     * Validation rules for updating an inventory record.
     */
    protected function updateRules(int $id): array
    {
        return [
            'item_name'           => 'required|unique:inventory,item_name,' . $id,
            'unit'                => 'required',
            'quantity'            => 'required|numeric|min:0',
            'minimum_stock_level' => 'required|numeric|min:0',
        ];
    }

    /**
     * Validation rules for the "use item" / stock-issue action.
     */
    protected function useItemRules(): array
    {
        return [
            'inventory_id'  => 'required|exists:inventory,id',
            'used_quantity' => 'required|numeric|min:1',
        ];
    }

    public function getAllItems()
    {
        return Item::all();
    }

    public function getAll()
    {
        return Inventory::all();
    }

    public function find(int $id): Inventory
    {
        return Inventory::findOrFail($id);
    }

    /**
     * Validate and create a new inventory record from an Item Master entry.
     *
     * @throws ValidationException
     */

    public function getItemInfo($item_id): array
    {
        $item = Item::findOrFail($item_id);

        $existing = Inventory::where('item_name', $item->item_name)->first();

        return [
            'exists'              => (bool) $existing,
            'unit'                => $item->unit,
            'current_quantity'    => $existing->quantity ?? 0,
            'minimum_stock_level' => $existing->minimum_stock_level ?? '',
        ];
    }
    
    public function create(array $data): Inventory
    {
        $validated = Validator::make($data, $this->storeRules())->validate();
        $item = Item::findOrFail($validated['item_id']);
        $existing = Inventory::where('item_name', $item->item_name)->first();

        if ($existing) {
            $existing->quantity += $validated['quantity'];
            $existing->minimum_stock_level = $validated['minimum_stock_level'];
            $existing->save();

            return $existing;
        }

        return Inventory::create([
            'item_name'           => $item->item_name,
            'unit'                => $item->unit,
            'quantity'            => $validated['quantity'],
            'minimum_stock_level' => $validated['minimum_stock_level'],
        ]);
    }

    /**
     * Validate and update an existing inventory record.
     *
     * @throws ValidationException
     */
    public function update(int $id, array $data): Inventory
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

    /**
     * Validate and process a stock-issue ("use item") request.
     * Returns an array describing the result instead of a JSON response,
     * so the controller stays responsible for the HTTP layer.
     *
     * @throws ValidationException
     */
    public function useItem(array $data): array
    {
        $validated = Validator::make($data, $this->useItemRules())->validate();

        $item = $this->find($validated['inventory_id']);

        if ($validated['used_quantity'] > $item->quantity) {
            return [
                'success' => false,
                'message' => 'Insufficient stock. Available: ' . $item->quantity,
            ];
        }

        $item->quantity -= $validated['used_quantity'];
        $item->save();

        return [
            'success' => true,
            'message' => 'Stock updated successfully. Remaining: ' . $item->quantity,
        ];
    }
}