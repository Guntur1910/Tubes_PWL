@extends('layouts.admin')

@section('title', 'Add Event')
@section('page-title', 'Add Event')

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <h3>Create New Event</h3>
        </div>

        <form action="{{ route('admin.events.store') }}" 
              method="POST" 
              enctype="multipart/form-data">

            @csrf

            <div class="card-body">

                {{-- EVENT NAME --}}
                <div class="form-group">
                    <label>Event Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                {{-- CATEGORY --}}
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        <option value="konser">Konser</option>
                        <option value="festival">Festival</option>
                        <option value="theater">Theater</option>
                    </select>
                </div>

                {{-- DESCRIPTION --}}
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>

                {{-- DATE --}}
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>

                {{-- LOCATION --}}
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" class="form-control" required>
                </div>

                {{-- QUOTA --}}
                <div class="form-group">
                    <label>Quota</label>
                    <input type="number" name="quota" class="form-control" required>
                </div>

                {{-- BASE PRICE --}}
                <div class="form-group">
                    <label>Base Price</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

                {{-- POSTER --}}
                <div class="form-group">
                    <label>Poster Event</label>
                    <input type="file" name="poster" class="form-control">
                    <small class="text-muted">Format: JPG, PNG (max 2MB)</small>
                </div>

                <hr>

                {{-- 🎫 TICKET TYPES --}}
                <h5>Ticket Types</h5>

                <div id="ticket-wrapper">

                    <div class="ticket-item mb-3 border p-3 rounded bg-light">

                        <input type="text" 
                               name="tickets[0][name]" 
                               class="form-control mb-2" 
                               placeholder="Ticket Name (VIP, Regular)" 
                               required>

                        <textarea name="tickets[0][description]" 
                                  class="form-control mb-2" 
                                  placeholder="Description"></textarea>

                        <input type="number" 
                               name="tickets[0][price]" 
                               class="form-control mb-2" 
                               placeholder="Price" 
                               required>

                        <input type="number" 
                               name="tickets[0][quota]" 
                               class="form-control mb-2" 
                               placeholder="Quota" 
                               required>

                        <button type="button" class="btn btn-danger btn-sm" onclick="removeTicket(this)">
                            Hapus
                        </button>
                    </div>

                </div>

                <button type="button" class="btn btn-success btn-sm" onclick="addTicket()">
                    + Add Ticket Type
                </button>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    Save Event
                </button>
            </div>

        </form>

    </div>

</div>

{{-- JS --}}
<script>
let index = 1;

function addTicket() {
    const wrapper = document.getElementById('ticket-wrapper');

    const html = `
        <div class="ticket-item mb-3 border p-3 rounded bg-light">

            <input type="text" 
                   name="tickets[${index}][name]" 
                   class="form-control mb-2" 
                   placeholder="Ticket Name" 
                   required>

            <textarea name="tickets[${index}][description]" 
                      class="form-control mb-2" 
                      placeholder="Description"></textarea>

            <input type="number" 
                   name="tickets[${index}][price]" 
                   class="form-control mb-2" 
                   placeholder="Price" 
                   required>

            <input type="number" 
                   name="tickets[${index}][quota]" 
                   class="form-control mb-2" 
                   placeholder="Quota" 
                   required>

            <button type="button" class="btn btn-danger btn-sm" onclick="removeTicket(this)">
                Hapus
            </button>

        </div>
    `;

    wrapper.insertAdjacentHTML('beforeend', html);
    index++;
}

function removeTicket(btn) {
    btn.closest('.ticket-item').remove();
}
</script>

@endsection