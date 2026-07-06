@extends('adminlte::page')

@section('title', 'User Management')

@section('content')
<div class="container-fluid">
    <h1>User Management</h1>
    <div class="card-body p-4" id="card">
         @if(session('success'))
         <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif
        <form action="{{ route('users.store') }}" method="POST" id="userForm" data-no-ajax-nav>
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter the Name">
                <span id="nameError" class="text-danger" style="display:none;">This name already exists.</span>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Enter the Email">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Phone</label>
                <input type="number" name="phone" class="form-control" placeholder="Enter the Phone">
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Category</label>
                <select name="role" class="form-control">
                    <option value="#">Select</option>
                    <option value="manager">Manager</option>
                    <option value="staff">Staff</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-control rounded">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="d-grid">
                <button type="submit" id="submitBtn" class="btn btn-primary btn-lg">
                    Save User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    window.checkNameRoute = "{{ route('users.checkName') }}"; 
    window.usersListRoute = "{{ route('users.list') }}";
</script>
<script src="{{ asset('js/check-name.js') }}"></script>
<script src="{{ asset('js/save-handler.js')}}"></script>
@endsection