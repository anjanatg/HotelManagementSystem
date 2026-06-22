<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SupplierService;

class SupplierController extends Controller
{
    protected SupplierService $supplierService;

    public function __construct(SupplierService $supplierService)
    {
        $this->supplierService = $supplierService;
    }

    public function index()
    {
        return view('suppliers.index');
    }

    public function store(Request $request)
    {
        $this->supplierService->create($request->all());

        return redirect()->route('suppliers.list')
                         ->with('success', 'Supplier added successfully');
    }

    public function list()
    {
        $suppliers = $this->supplierService->getAll();
        return view('suppliers.view', compact('suppliers'));
    }

    public function edit($id)
    {
        $supplier = $this->supplierService->find($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $this->supplierService->update($id, $request->all());

        return redirect()->route('suppliers.list')
                         ->with('success', 'Supplier updated successfully');
    }

    public function destroy($id)
    {
        $this->supplierService->delete($id);

        return redirect()->route('suppliers.list')
                         ->with('success', 'Supplier deleted successfully');
    }
}