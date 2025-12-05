@extends('layouts.seller')

@section('seller-content')
    {{-- HEADER DASHBOARD (sama, cuma tombol balik ke dashboard boleh ditambah) --}}
    <div class="seller-header-card">
        <div class="seller-header-left">
            <div class="seller-logo-circle">
                SP
            </div>
            <div>
                <div class="seller-header-title">
                    Tambah Produk Baru
                </div>
                <div class="seller-header-subtitle">
                    Lengkapi detail produk sebelum dipublikasikan
                </div>
            </div>
        </div>
        <div class="seller-header-right">
            <a href="{{ route('seller.dashboard') }}" class="btn-outline-grey">
                Kembali ke Dashboard
            </a>
            <div class="seller-avatar">
                <i class="bi bi-person"></i>
            </div>
        </div>
    </div>

    <div class="seller-products-card">
        {{-- HEADER UPLOAD --}}
        <div class="seller-upload-header">
            <div class="seller-upload-icon-box">
                {{-- icon default --}}
                <i class="bi bi-image" id="upload-icon"></i>

                {{-- preview utama, disembunyikan dulu --}}
                <img id="upload-preview"
                     src=""
                     alt="Preview"
                     class="upload-preview-img d-none">
            </div>

            <button type="button" class="btn btn-upload-photo"
                    onclick="document.getElementById('input-gambar-upload').click()">
                Upload Photo
            </button>
            <div style="font-size: 11px; color: var(--text-muted); margin-top: 6px;">
                Pilih satu atau lebih foto produk (jpg/png, maks. 2MB per file)
            </div>

            {{-- tempat thumbnail semua foto --}}
            <div id="upload-thumbs"
                 class="mt-3 d-flex justify-content-center gap-2 flex-wrap">
            </div>
        </div>

        {{-- ERROR VALIDATION --}}
        @if($errors->any())
            <div class="alert alert-danger" style="font-size: 13px;">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- input file hidden --}}
            <input type="file"
                   id="input-gambar-upload"
                   name="gambar[]"
                   class="d-none"
                   multiple>

            <div class="seller-form-shell">
                {{-- NAMA PRODUK --}}
                <div class="seller-question-card">
                    <div class="seller-question-label">Nama Produk*</div>
                    <input type="text" name="nama_produk"
                           class="seller-input"
                           placeholder="Contoh: Diktat Dasar Pemrograman"
                           required
                           value="{{ old('nama_produk') }}">
                    <div class="seller-question-helper">
                        Gunakan nama yang jelas dan mudah dicari.
                    </div>
                </div>

                {{-- DESKRIPSI --}}
                <div class="seller-question-card">
                    <div class="seller-question-label">Deskripsi*</div>
                    <textarea name="deskripsi"
                              class="seller-input seller-textarea"
                              placeholder="Deskripsi singkat produk"
                              required>{{ old('deskripsi') }}</textarea>
                    <div class="seller-question-helper">
                        Tambahkan detail penting seperti kondisi, warna, ukuran, dll.
                    </div>
                </div>

                {{-- KATEGORI --}}
                <div class="seller-question-card">
                    <div class="seller-question-label">Kategori*</div>
                    <select name="category_id" class="seller-input" required>
                        <option value="">Pilih kategori</option>
                        <option value="1" {{ old('category_id') == 1 ? 'selected' : '' }}>Kecantikan</option>
                        <option value="2" {{ old('category_id') == 2 ? 'selected' : '' }}>Fashion</option>
                        <option value="3" {{ old('category_id') == 3 ? 'selected' : '' }}>Elektronik</option>
                        <option value="4" {{ old('category_id') == 4 ? 'selected' : '' }}>Rumah Tangga</option>
                        <option value="5" {{ old('category_id') == 5 ? 'selected' : '' }}>Sport</option>
                        <option value="6" {{ old('category_id') == 6 ? 'selected' : '' }}>Pendidikan</option>
                    </select>
                </div>

                {{-- STOK --}}
                <div class="seller-question-card">
                    <div class="seller-question-label">Stok*</div>
                    <input type="number" name="stok"
                           class="seller-input"
                           placeholder="Contoh: 10"
                           min="0" required
                           value="{{ old('stok') }}">
                </div>

                {{-- HARGA --}}
                <div class="seller-question-card">
                    <div class="seller-question-label">Harga*</div>
                    <input type="number" name="harga"
                           class="seller-input"
                           placeholder="Contoh: 35000"
                           min="0" required
                           value="{{ old('harga') }}">
                </div>

                <div class="text-center mt-2">
                    <button type="submit" class="seller-modal-btn">
                        Upload Produk
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input   = document.getElementById('input-gambar-upload');
    const icon    = document.getElementById('upload-icon');
    const preview = document.getElementById('upload-preview');
    const thumbs  = document.getElementById('upload-thumbs');

    if (!input) return;

    input.addEventListener('change', function (e) {
        const files = e.target.files;

        // tidak ada file dipilih
        if (!files || files.length === 0) {
            if (preview) {
                preview.classList.add('d-none');
                preview.src = '';
            }
            if (icon) icon.style.display = 'inline-block';
            if (thumbs) thumbs.innerHTML = '';
            return;
        }

        // ===== PREVIEW UTAMA: file pertama =====
        const firstFile = files[0];
        const readerMain = new FileReader();
        readerMain.onload = function (ev) {
            if (preview) {
                preview.src = ev.target.result;
                preview.classList.remove('d-none');
            }
            if (icon) icon.style.display = 'none';
        };
        readerMain.readAsDataURL(firstFile);

        // ===== THUMBNAIL SEMUA FOTO =====
        if (thumbs) {
            thumbs.innerHTML = '';
            Array.from(files).forEach(function (file) {
                const r = new FileReader();
                r.onload = function (ev2) {
                    const img = document.createElement('img');
                    img.src = ev2.target.result;
                    img.className = 'upload-thumb';
                    thumbs.appendChild(img);
                };
                r.readAsDataURL(file);
            });
        }
    });
});
</script>
@endpush
