@extends('adminlte::page')
@section('title', 'Edit Inventory Item')

@section('content')
<div class="card">
    <div class="card-header"><h3>Edit Inventory Item</h3></div>
    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('inventory.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Item Name</label>
                <input type="text" name="item_name" class="form-control" value="{{ old('item_name', $item->item_name) }}">
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="unit" class="form-control" value="{{ old('unit', $item->unit) }}">
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control" value="{{ old('quantity', $item->quantity) }}">
            </div>
            <div class="form-group">
                <label>Minimum Stock Level</label>
                <input type="number" name="minimum_stock_level" class="form-control" value="{{ old('minimum_stock_level', $item->minimum_stock_level) }}">
            </div>
            <button type="submit" class="btn btn-success">Update Item</button>
            <a href="{{ route('inventory.list') }}" class="btn btn-secondary">Cancel</a>
        </form>

    </div>
</div>
@endsection