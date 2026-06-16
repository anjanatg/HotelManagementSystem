<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserManagement;

class UserManagementController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required|unique:user_management,name',
            'email'  => 'required|email|unique:user_management,email',
            'phone'  => 'required|numeric|digits:10',
            'role'   => 'required',
            'status' => 'required',
        ]);

        UserManagement::create([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'role'   => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('users.list')
                         ->with('success', 'User added successfully');
    }

    public function list()
    {
        $users = UserManagement::all();
        return view('users.view', compact('users'));
    }

    // ✅ ഇത് മുതൽ താഴേക്ക് add ചെയ്യൂ
    public function edit($id)
    {
        $user = UserManagement::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = UserManagement::findOrFail($id);

        $request->validate([
            'name'   => 'required|unique:user_management,name,' . $id,
            'email'  => 'required|email|unique:user_management,email,' . $id,
            'phone'  => 'required|numeric|digits:10',
            'role'   => 'required',
            'status' => 'required',
        ]);

        $user->update([
            'name'   => $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'role'   => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->route('users.list')
                         ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        UserManagement::findOrFail($id)->delete();
        return redirect()->route('users.list')
                         ->with('success', 'User deleted successfully');
    }
}