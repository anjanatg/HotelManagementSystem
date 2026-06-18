@extends('adminlte::page')
@section('title', 'Use Item')

@section('content')
<div class="card">
    <div class="card-header"><h3>Use Item (Issue Stock)</h3></div>
    <div class="card-body">

        <div id="alertBox" style="display:none;" class="alert"></div>

        <form id="useItemForm">
            @csrf
            <div class="form-group">
                <label>Item Name</label>
                <select name="inventory_id" id="inventory_id" class="form-control">
                    <option value="">-- Select Item --</option>
                    @foreach($items as $item)
                    <option value="{{ $item->id }}" data-available="{{ $item->quantity }}">
                        {{ $item->item_name }} ({{ $item->unit }}) - Available: {{ $item->quantity }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Quantity to Use</label>
                <input type="number" name="used_quantity" id="used_quantity" class="form-control" min="1">
                <span id="qtyError" class="text-danger" style="display:none;"></span>
            </div>

            <button type="submit" class="btn btn-primary">Use Item</button>
        </form>

    </div>
</div>

<script>
    window.useItemRoute = "{{ route('inventory.useItem') }}";
</script>
<script src="{{ asset('js/use-item.js') }}"></script>
@endsection