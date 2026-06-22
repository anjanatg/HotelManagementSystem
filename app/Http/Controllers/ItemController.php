<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ItemService;

class ItemController extends Controller
{
    protected ItemService $itemService;

    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    public function index()
    {
        $items = $this->itemService->getAll();
        return view('items.index', compact('items'));
    }

    public function store(Request $request)
    {
        $this->itemService->create($request->all());

        return redirect()->route('items.index')
                         ->with('success', 'Item created successfully');
    }

    public function list()
    {
        $items = $this->itemService->getAll();
        return view('items.view', compact('items'));
    }

    public function edit($id)
    {
        $item = $this->itemService->find($id);
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $this->itemService->update($id, $request->all());

        return redirect()->route('items.index')
                         ->with('success', 'Item updated successfully');
    }

    public function destroy($id)
    {
        $this->itemService->delete($id);

        return redirect()->route('items.index')
                         ->with('success', 'Item deleted successfully');
    }
}