@extends('layouts.user')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

<style>
    .edit-card {
        border: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    .edit-card:hover {
        box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important;
    }
    .avatar-wrapper {
        position: relative;
        display: inline-block;
    }
    .avatar-preview {
        width: 140px;
        height: 140px;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .avatar-wrapper:hover .avatar-preview {
        transform: scale(1.02);
    }
    .btn-edit-avatar {
        position: absolute;
        bottom: 5px;
        right: 5px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 3px solid #fff;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        transition: all 0.2s ease;
    }
    .btn-edit-avatar:hover {
        transform: scale(1.1);
        background: linear-gradient(135deg, #5a6fd6, #673f91);
    }
    .custom-input {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        padding: 0.75rem 1.25rem;
        transition: all 0.2s ease;
    }
    .custom-input:focus {
        background-color: #ffffff;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
    }
    .form-label {
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }
    .btn-custom-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-custom-primary:hover {
        background: linear-gradient(135deg, #5a6fd6, #673f91);
        color: white;
        box-shadow: 0 8px 20px rgba(118, 75, 162, 0.4);
        transform: translateY(-2px);
    }
    /* Memperbaiki tinggi modal agar lebih nyaman di HP */
    .img-container img {
        max-width: 100%;
        max-height: 60vh;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-xl-6">

            <div class="card edit-card shadow-lg border-0 rounded-4 overflow-hidden">
                {{-- Header Aksentuasi --}}
                <div style="height: 8px; background: linear-gradient(135deg, #667eea, #764ba2);"></div>
                
                <div class="card-body p-4 p-sm-5 text-center">

                    <h3 class="mb-1 fw-bolder text-dark">Edit Profile</h3>
                    <p class="text-muted mb-4 pb-2">Perbarui informasi akun dan foto profil Anda</p>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        {{-- AVATAR UPLOAD --}}
                        <div class="mb-5">
                            <div class="avatar-wrapper">
                                <img id="previewImage"
                                    src="{{ auth()->user()->photo 
                                        ? asset('storage/profile/' . auth()->user()->photo)
                                        : asset('assets/images/profile/user-1.jpg') }}"
                                    class="rounded-circle avatar-preview"
                                    alt="Profile Image">

                                <label for="photoInput" class="btn-edit-avatar" title="Ganti Foto">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                        <path d="M15 12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h1.172a3 3 0 0 0 2.12-.879l.83-.828A1 1 0 0 1 6.827 3h2.344a1 1 0 0 1 .707.293l.828.828A3 3 0 0 0 12.828 5H14a1 1 0 0 1 1 1v6zM2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2z"/>
                                        <path d="M8 11a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5zm0 1a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zM3 6.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
                                    </svg>
                                </label>
                            </div>

                            <input type="file" id="photoInput" class="d-none" accept="image/png, image/jpeg, image/jpg">
                            <input type="hidden" name="photo_cropped" id="photoCropped">
                        </div>

                        {{-- USER DETAILS --}}
                        <div class="mb-4 text-start">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control form-control-lg custom-input rounded-3" placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="mb-4 text-start">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control form-control-lg custom-input rounded-3" placeholder="contoh@email.com" required>
                        </div>

                        {{-- DIVIDER --}}
                        <div class="d-flex align-items-center my-4">
                            <hr class="flex-grow-1 text-muted opacity-25">
                            <span class="mx-3 text-muted small fw-semibold text-uppercase letter-spacing-1">Keamanan</span>
                            <hr class="flex-grow-1 text-muted opacity-25">
                        </div>

                        {{-- PASSWORD UPDATE --}}
                        <div class="mb-3 text-start bg-light p-3 rounded-4 border border-1">
                            <div class="d-flex align-items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-primary me-2" viewBox="0 0 16 16">
                                    <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                                </svg>
                                <small class="text-muted fw-semibold">Ubah Password (Opsional)</small>
                            </div>
                            <small class="text-muted d-block mb-3" style="font-size: 0.8rem;">Biarkan kolom di bawah ini kosong jika Anda tidak ingin mengubah password saat ini.</small>

                            <div class="mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control custom-input rounded-3" placeholder="Masukkan password baru">
                            </div>

                            <div class="mb-2">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" class="form-control custom-input rounded-3" placeholder="Ulangi password baru">
                            </div>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="d-flex flex-column flex-sm-row justify-content-end gap-3 mt-5">
                            <a href="{{ route('profile') }}" class="btn btn-light border px-4 py-2 rounded-pill fw-semibold order-2 order-sm-1">Batal</a>
                            <button type="submit" class="btn btn-custom-primary px-5 py-2 rounded-pill fw-semibold order-1 order-sm-2">Simpan Perubahan</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- MODAL CROPPER --}}
<div class="modal fade" id="cropModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light border-bottom-0 p-4">
                <h5 class="modal-title fw-bold text-dark">Sesuaikan Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 bg-dark text-center img-container">
                <img id="cropImage" src="" alt="Gambar untuk di-crop">
            </div>
            <div class="modal-footer border-top-0 p-4 bg-light d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-custom-primary rounded-pill px-4" id="cropBtn">Crop & Gunakan</button>
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

$('#photoInput').on('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    // Reset input
    $(this).val('');

    const reader = new FileReader();
    reader.onload = function(event) {
        image.src = event.target.result;
        // Buka modal pakai cara Bootstrap 4 (jQuery)
        $('#cropModal').modal('show');
    };
    reader.readAsDataURL(file);
});

// Setup Cropper saat modal selesai terbuka
$('#cropModal').on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
        aspectRatio: 1,
        viewMode: 1,
        dragMode: 'move',
        autoCropArea: 1,
        restore: false,
        guides: true,
        center: true,
        highlight: false,
        cropBoxMovable: true,
        cropBoxResizable: true,
        toggleDragModeOnDblclick: false,
    });
});

// Hancurkan cropper saat modal ditutup
$('#cropModal').on('hidden.bs.modal', function () {
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
});

$('#cropBtn').on('click', function() {
    if (!cropper) return;

    const canvas = cropper.getCroppedCanvas({
        width: 400,
        height: 400,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
    });

    const croppedImage = canvas.toDataURL('image/png');

    // Update image preview & hidden input
    preview.src = croppedImage;
    $('#photoCropped').val(croppedImage);

    // Tutup modal
    $('#cropModal').modal('hide');
});
</script>
@endsection