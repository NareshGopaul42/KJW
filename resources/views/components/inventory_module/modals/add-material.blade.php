@extends('layouts.app')
@section('content')
    <div class="container-inventory">
        <!-- Header with buttons -->
        @include('components.inventory.partials.header')
        
        <!-- Search and filters -->
        @include('components.inventory.partials.search-filter')
        
        <!-- Material Cards -->
        @include('components.inventory.partials.material-card')
        
        <!-- Modals -->
        @include('components.inventory.modals.add-material')
        @include('components.inventory.modals.record-receipt')
    </div>
@endsection