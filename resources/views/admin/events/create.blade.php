@extends('layouts.admin')

@section('title', 'Add Event')
@section('page-title', 'Add Event')

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Create New Event</h3>
        </div>

        <form action="{{ route('admin.events.store') }}" method="POST">
            @csrf

            <div class="card-body">

                <div class="form-group">
                    <label>Event Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Quota</label>
                    <input type="number" name="quota" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    Save Event
                </button>
                <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

@endsection