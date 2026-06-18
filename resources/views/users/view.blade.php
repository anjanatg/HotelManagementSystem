@extends('adminlte::page')
@section('title', 'User List')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>User List</h3>
        <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm float-right">+ Add User</a>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table id="usersTable" class="table table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('plugins.Datatables', true)

@section('js')
<script>
    window.usersListRoute = "{{ route('users.list') }}";
</script>
<script src="{{ asset('js/users-datatable.js') }}"></script>
@endsection