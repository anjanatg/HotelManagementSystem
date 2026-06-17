<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all(); 
        return view('items.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_name' => 'required|unique:items,item_name',
            'unit'      => 'required',
        ]);

        Item::create([
            'item_name' => $request->item_name,
            'unit'      => $request->unit,
        ]);

        return redirect()->route('items.index')
                         ->with('success', 'Item created successfully');
    }

    public function list()
    {
        $items = Item::all();
        return view('items.view', compact('items'));
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'item_name' => 'required|unique:items,item_name,' . $id,
            'unit'      => 'required',
        ]);

        $item->update([
            'item_name' => $request->item_name,
            'unit'      => $request->unit,
        ]);

        return redirect()->route('items.index')
                         ->with('success', 'Item updated successfully');
    }

    public function destroy($id)
    {
        Item::findOrFail($id)->delete();
        return redirect()->route('items.index')
                         ->with('success', 'Item deleted successfully');
    }
}