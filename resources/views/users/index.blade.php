@extends('adminlte::page')

@section('title', 'User Management')

@section('content')
<div class="container-fluid">
    <h1>User Management</h1>
    <div class="card-body p-4" id="card">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter the Name">
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
                <button type="submit" class="btn btn-primary btn-lg">
                    Save Product
                </button>
            </div>
        </form>
    </div>
</div>
    
@endsection