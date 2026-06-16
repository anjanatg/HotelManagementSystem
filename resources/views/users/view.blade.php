@extends('adminlte::page')

@section('title', 'User List')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>User List</h3>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->status }}</td>
                    <td>
                        {{-- Edit Button --}}
                        <a href="{{ route('users.edit', $user->id) }}"
                            class="btn btn-warning btn-sm px-3">Edit
                        </a>
                        &nbsp;&nbsp;&nbsp;
                        {{-- Delete Button --}}
                        <form action="{{ route('users.destroy', $user->id) }}"
                            method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm px-3"
                                onclick="return confirm('Delete this user?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection