<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        return view('suppliers.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|unique:suppliers,name',
            'email'   => 'required|email|unique:suppliers,email',
            'phone'   => 'required|numeric|digits:10',
            'company' => 'required',
            'address' => 'required',
            'status'  => 'required',
        ]);

        Supplier::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'company' => $request->company,
            'address' => $request->address,
            'status'  => $request->status,
        ]);

        return redirect()->route('suppliers.list')
                         ->with('success', 'Supplier added successfully');
    }

    public function list()
    {
        $suppliers = Supplier::all();
        return view('suppliers.view', compact('suppliers'));
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $request->validate([
            'name'    => 'required|unique:suppliers,name,' . $id,
            'email'   => 'required|email|unique:suppliers,email,' . $id,
            'phone'   => 'required|numeric|digits:10',
            'company' => 'required',
            'address' => 'required',
            'status'  => 'required',
        ]);

        $supplier->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'company' => $request->company,
            'address' => $request->address,
            'status'  => $request->status,
        ]);

        return redirect()->route('suppliers.list')
                         ->with('success', 'Supplier updated successfully');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();
        return redirect()->route('suppliers.list')
                         ->with('success', 'Supplier deleted successfully');
    }
}