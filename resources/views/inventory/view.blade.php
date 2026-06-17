@extends('adminlte::page')
@section('title', 'Inventory List')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Inventory List</h3>
        <a href="{{ route('inventory.index') }}" class="btn btn-primary btn-sm float-right">+ Add Item</a>
    </div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Item Name</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Min Stock Level</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->unit }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->minimum_stock_level }}</td>
                    <td>
                        @if($item->status == 'Low Stock')
                            <span class="badge badge-danger">{{ $item->status }}</span>
                        @else
                            <span class="badge badge-success">{{ $item->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" style="display:inline; margin-left:10px;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this item?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection