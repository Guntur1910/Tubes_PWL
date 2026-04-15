@extends('layouts.admin')

@section('title', 'Edit Event')

@section('content')

<div class="container-fluid">

    <div class="card">
        <div class="card-header">
            <h3>Edit Event</h3>
        </div>

        <form action="{{ route('admin.events.update', $event->id) }}" 
              method="POST" 
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="card-body">

                {{-- EVENT NAME --}}
                <div class="form-group">
                    <label>Event Name</label>
                    <input type="text" name="name" value="{{ $event->name }}" class="form-control" required>
                </div>

                {{-- CATEGORY --}}
                <div class="form-group">
                    <label>Category</label>
                    <select name="category" class="form-control" required>
                        <option value="konser" {{ $event->category == 'konser' ? 'selected' : '' }}>Konser</option>
                        <option value="festival" {{ $event->category == 'festival' ? 'selected' : '' }}>Festival</option>
                        <option value="theater" {{ $event->category == 'theater' ? 'selected' : '' }}>Theater</option>
                    </select>
                </div>

                {{-- DESCRIPTION --}}
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" required>{{ $event->description }}</textarea>
                </div>

                {{-- DATE --}}
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" 
                           name="date" 
                           value="{{ \Carbon\Carbon::parse($event->date)->format('Y-m-d') }}" 
                           class="form-control" 
                           required>
                </div>

                {{-- LOCATION --}}
                <div class="form-group">
                    <label>Location</label>
                    <input type="text" name="location" value="{{ $event->location }}" class="form-control" required>
                </div>

                {{-- QUOTA --}}
                <div class="form-group">
                    <label>Quota</label>
                    <input type="number" name="quota" value="{{ $event->quota }}" class="form-control" required>
                </div>

                {{-- BASE PRICE --}}
                <div class="form-group">
                    <label>Base Price</label>
                    <input type="number" name="price" value="{{ $event->price }}" class="form-control" required>
                </div>

                {{-- POSTER --}}
                <div class="form-group">
                    <label>Poster Event</label><br>

                    @if($event->poster)
                        <img src="{{ asset('storage/' . $event->poster) }}" 
                             width="200" 
                             class="mb-2 rounded shadow">
                    @else
                        <p class="text-muted">Belum ada poster</p>
                    @endif

                    <input type="file" name="poster" class="form-control">
                </div>

                <hr>

                {{-- 🎫 TICKET TYPES --}}
                <h5>Ticket Types</h5>

                <div id="ticket-wrapper">

                    @forelse($event->ticketTypes as $i => $ticket)
                    <div class="ticket-item mb-3 border p-3 rounded bg-light">

                        <input type="hidden" name="tickets[{{ $i }}][id]" value="{{ $ticket->id }}">

                        <input type="text" 
                               name="tickets[{{ $i }}][name]" 
                               value="{{ $ticket->name }}" 
                               class="form-control mb-2" 
                               placeholder="Ticket Name" required>

                        <textarea name="tickets[{{ $i }}][description]" 
                                  class="form-control mb-2" 
                                  placeholder="Description">{{ $ticket->description }}</textarea>

                        <input type="number" 
                               name="tickets[{{ $i }}][price]" 
                               value="{{ $ticket->price }}" 
                               class="form-control mb-2" 
                               placeholder="Price" required>

                        <input type="number" 
                               name="tickets[{{ $i }}][quota]" 
                               value="{{ $ticket->quota }}" 
                               class="form-control mb-2" 
                               placeholder="Quota" required>

                        <button type="button" class="btn btn-danger btn-sm" onclick="removeTicket(this)">
                            Hapus
                        </button>
                    </div>
                    @empty
                        <p class="text-muted">Belum ada ticket</p>
                    @endforelse

                </div>

                <button type="button" class="btn btn-success btn-sm" onclick="addTicket()">
                    + Add Ticket
                </button>

            </div>

            <div class="card-footer">
                <button class="btn btn-primary">Update</button>
            </div>

        </form>

    </div>

</div>

{{-- JS --}}
<script>
let index = {{ $event->ticketTypes->count() ?? 0 }};

function addTicket() {
    const wrapper = document.getElementById('ticket-wrapper');

    const html = `
        <div class="ticket-item mb-3 border p-3 rounded bg-light">
            <input type="text" name="tickets[${index}][name]" class="form-control mb-2" placeholder="Ticket Name" required>

            <textarea name="tickets[${index}][description]" class="form-control mb-2" placeholder="Description"></textarea>

            <input type="number" name="tickets[${index}][price]" class="form-control mb-2" placeholder="Price" required>

            <input type="number" name="tickets[${index}][quota]" class="form-control mb-2" placeholder="Quota" required>

            <button type="button" class="btn btn-danger btn-sm" onclick="removeTicket(this)">Hapus</button>
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