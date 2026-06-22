<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InventoryService;

class InventoryController extends Controller
{
    protected InventoryService $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    public function index()
    {
        $items = $this->inventoryService->getAllItems();
        return view('inventory.index', compact('items'));
    }

    public function store(Request $request)
    {
        $this->inventoryService->create($request->all());

        return redirect()->route('inventory.list')
                         ->with('success', 'Item added successfully');
    }

    public function list()
    {
        $items = $this->inventoryService->getAll();
        return view('inventory.view', compact('items'));
    }

    public function edit($id)
    {
        $item = $this->inventoryService->find($id);
        return view('inventory.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $this->inventoryService->update($id, $request->all());

        return redirect()->route('inventory.list')
                         ->with('success', 'Item updated successfully');
    }

    public function destroy($id)
    {
        $this->inventoryService->delete($id);

        return redirect()->route('inventory.list')
                         ->with('success', 'Item deleted successfully');
    }

    public function useItemForm()
    {
        $items = $this->inventoryService->getAll();
        return view('inventory.use', compact('items'));
    }

    public function useItem(Request $request)
    {
        $result = $this->inventoryService->useItem($request->all());

        return response()->json($result);
    }
}