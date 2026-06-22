<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserManagementService;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    protected UserManagementService $userService;

    public function __construct(UserManagementService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('users.index');
    }

    public function checkName(Request $request)
    {
        $exists = $this->userService->nameExists($request->name);
        return response()->json(['exists' => $exists]);
    }

    public function store(Request $request)
    {
        $this->userService->create($request->all());

        return redirect()->route('users.list')
                         ->with('success', 'User added successfully');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->userService->getAll();

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
        $user = $this->userService->find($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->userService->update($id, $request->all());

        return redirect()->route('users.list')
                         ->with('success', 'User updated successfully');
    }

    public function destroy($id)
    {
        $this->userService->delete($id);

        return redirect()->route('users.list')
                         ->with('success', 'User deleted successfully');
    }
}