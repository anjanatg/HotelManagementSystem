@extends('adminlte::page')
@section('title', 'Add Item')

@section('content')
<div class="row">

    {{-- Left Column: Add Item Form --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-header"><h3>Add Item</h3></div>
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

                <form action="{{ route('items.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Item Name</label>
                        <input type="text" name="item_name" class="form-control" value="{{ old('item_name') }}">
                    </div>
                    <div class="form-group">
                        <label>Unit</label>
                        <input type="text" name="unit" class="form-control" placeholder="e.g. kg, pcs, litre" value="{{ old('unit') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Item</button>
                </form>

            </div>
        </div>
    </div>

    {{-- Right Column: Item List --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3>Item List</h3>
            </div>
            <div class="card-body">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Item Name</th>
                            <th>Unit</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>
                                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
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
    </div>

</div>
@endsection