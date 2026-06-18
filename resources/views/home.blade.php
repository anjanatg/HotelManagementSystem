@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
   <div class="row">
        <div class="col-md-6 mb-3">
            <div class="dashboard-card bg-success">
                <div class="card-body">
                    <h5>Item Count</h5>
                    <h2>{{ $itemCount }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="dashboard-card bg-primary">
                <div class="card-body">
                    <h5>Staff Count</h5>
                    <h2>{{ $staffCount }}</h2>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop