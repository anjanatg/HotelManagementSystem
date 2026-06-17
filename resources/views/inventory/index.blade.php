@extends('adminlte::page')
@section('title', 'Add Inventory Item')

@section('content')
<div class="card">
    <div class="card-header"><h3>Add Inventory Item</h3></div>
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('inventory.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Item Name</label>
                <select name="item_id" id="item_id" class="form-control @error('item_id') is-invalid @enderror" onchange="updateUnit()">
                    <option value="">-- Select Item --</option>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}" data-unit="{{ $item->unit }}" {{ old('item_id') == $item->id ? 'selected' : '' }}>
                        {{ $item->item_name }}
                    </option>
                    @endforeach
                </select>
                @error('item_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="unit" id="unit" class="form-control" readonly value="{{ old('unit') }}">
            </div>

            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control" value="{{ old('quantity') }}">
            </div>
            <div class="form-group">
                <label>Minimum Stock Level</label>
                <input type="number" name="minimum_stock_level" class="form-control" value="{{ old('minimum_stock_level') }}">
            </div>
            <button type="submit" class="btn btn-primary">Add Item</button>
        </form>

    </div>
</div>

<script>
function updateUnit() {
    const select = document.getElementById('item_id');
    const selectedOption = select.options[select.selectedIndex];
    const unit = selectedOption.getAttribute('data-unit') || '';
    document.getElementById('unit').value = unit;
}
</script>
@endsection