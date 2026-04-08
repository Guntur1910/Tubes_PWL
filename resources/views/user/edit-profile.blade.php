@extends('layouts.user')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body text-center">

                    <h3 class="mb-4 fw-bold">Edit Profile</h3>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- AVATAR --}}
                        <div class="mb-4">
                            <div class="position-relative d-inline-block">

                                <img id="previewImage"
                                    src="{{ auth()->user()->photo 
                                        ? asset('storage/profile/' . auth()->user()->photo)
                                        : asset('assets/images/profile/user-1.jpg') }}"
                                    class="rounded-circle shadow"
                                    width="130" height="130"
                                    style="object-fit:cover; cursor:pointer;">

                                <label for="photoInput"
                                    class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2"
                                    style="cursor:pointer;">
                                    📷
                                </label>
                            </div>

                            <input type="file" id="photoInput" class="d-none" accept="image/*">
                            <input type="hidden" name="photo_cropped" id="photoCropped">

                            <small class="text-muted d-block mt-2">
                                Klik foto untuk mengganti
                            </small>
                        </div>

                        {{-- NAME --}}
                        <div class="mb-3 text-start">
                            <label>Nama</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control">
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-3 text-start">
                            <label>Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control">
                        </div>

                        <hr>

                        {{-- PASSWORD --}}
                        <div class="mb-3 text-start">
                            <label>Password Baru</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3 text-start">
                            <label>Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('profile') }}" class="btn btn-secondary rounded-pill">Kembali</a>
                            <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL CROP --}}
<div class="modal fade" id="cropModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Crop Foto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <img id="cropImage" style="max-width:100%;">
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="cropBtn">Crop & Gunakan</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
let cropper;
const input = document.getElementById('photoInput');
const image = document.getElementById('cropImage');
const preview = document.getElementById('previewImage');

input.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(event) {
        image.src = event.target.result;

        const modal = new bootstrap.Modal(document.getElementById('cropModal'));
        modal.show();

        image.onload = function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 1,
            });
        }
    };
    reader.readAsDataURL(file);
});

document.getElementById('cropBtn').addEventListener('click', function() {
    const canvas = cropper.getCroppedCanvas({
        width: 300,
        height: 300
    });

    const croppedImage = canvas.toDataURL('image/png');

    preview.src = croppedImage;
    document.getElementById('photoCropped').value = croppedImage;

    bootstrap.Modal.getInstance(document.getElementById('cropModal')).hide();
});
</script>
@endsection