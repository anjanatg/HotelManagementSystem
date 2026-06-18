<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserManagement;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    public function index()
    {
        return view('users.index');
    }
    public function checkName(Request $request)
    {
        $exists = UserManagement::where('name', $request->name)->exists();
        return response()->json(['exists' => $exists]);
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

    public function list(Request $request)
{
    if ($request->ajax()) {
        $data = UserManagement::select('*');

        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                $editUrl = route('users.edit', $row->id);
                $deleteUrl = route('users.destroy', $row->id);

                $btn = '<a href="' . $editUrl . '" class="btn btn-warning btn-sm">Edit</a>';
                $btn .= ' <form action="' . $deleteUrl . '" method="POST" style="display:inline;">';
                $btn .= csrf_field();
                $btn .= method_field('DELETE');
                $btn .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Delete this user?\')">Delete</button>';
                $btn .= '</form>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('users.view');
}

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