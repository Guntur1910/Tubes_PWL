@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <h3>Edit Event</h3>
        </div>

        <form action="{{ route('admin.events.update', $event->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                <div class="form-group">
                    <label>Event Name</label>
                    <input type="text" name="name" 
                        value="{{ $event->name }}" 
                        class="form-control">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" 
                        class="form-control">{{ $event->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" 
                        value="{{ $event->date }}" 
                        class="form-control">
                </div>

                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" 
                        value="{{ $event->location }}" 
                        class="form-control">
                </div>

                <div class="form-group">
                    <label>Quota</label>
                    <input type="number" name="quota" 
                        value="{{ $event->quota }}" 
                        class="form-control">
                </div>

                <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="price" 
                        value="{{ $event->price }}" 
                        class="form-control">
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    Update
                </button>
                <a href="{{ route('admin.events.index') }}" 
                   class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

@endsection