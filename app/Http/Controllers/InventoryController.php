<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Item;

class InventoryController extends Controller
{
    public function index()
    {
        $items = Item::all(); 
        return view('inventory.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_id'              => 'required|exists:items,id', 
            'quantity'             => 'required|numeric|min:0',
            'minimum_stock_level'  => 'required|numeric|min:0',
        ]);

        $item = Item::findOrFail($request->item_id);

        Inventory::create([
            'item_name'            => $item->item_name,
            'unit'                 => $item->unit,
            'quantity'             => $request->quantity,
            'minimum_stock_level'  => $request->minimum_stock_level,
        ]);

        return redirect()->route('inventory.list')
                         ->with('success', 'Item added successfully');
    }

    public function list()
    {
        $items = Inventory::all();
        return view('inventory.view', compact('items'));
    }

    public function edit($id)
    {
        $item = Inventory::findOrFail($id);
        return view('inventory.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Inventory::findOrFail($id);

        $request->validate([
            'item_name'            => 'required|unique:inventory_items,item_name,' . $id,
            'unit'                 => 'required',
            'quantity'             => 'required|numeric|min:0',
            'minimum_stock_level'  => 'required|numeric|min:0',
        ]);

        $item->update([
            'item_name'            => $request->item_name,
            'unit'                 => $request->unit,
            'quantity'             => $request->quantity,
            'minimum_stock_level'  => $request->minimum_stock_level,
        ]);

        return redirect()->route('inventory.list')
                         ->with('success', 'Item updated successfully');
    }

    public function destroy($id)
    {
        Inventory::findOrFail($id)->delete();
        return redirect()->route('inventory.list')
                         ->with('success', 'Item deleted successfully');
    }
}
