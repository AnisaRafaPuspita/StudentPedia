@extends('layouts.seller')

@section('seller-content')
    {{-- HEADER EDIT --}}
    <div class="seller-header-card">
        <div class="seller-header-left">
            <div class="seller-logo-circle">
                SP
            </div>
            <div>
                <div class="seller-header-title">
                    Edit Produk
                </div>
                <div class="seller-header-subtitle">
                    Update informasi produkmu di StudentPedia
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
        {{-- HEADER EDIT + PREVIEW FOTO --}}
        <div class="seller-upload-header">
            <div class="seller-upload-icon-box">
                {{-- kalau ada gambar lama, tampilkan sebagai preview default --}}
                @if($product->gambar)
                    <img id="edit-preview"
                         src="{{ asset('storage/' . $product->gambar) }}"
                         alt="Preview"
                         class="upload-preview-img">
                    <i class="bi bi-image d-none" id="edit-icon"></i>
                @else
                    <i class="bi bi-image" id="edit-icon"></i>
                    <img id="edit-preview"
                         src=""
                         alt="Preview"
                         class="upload-preview-img d-none">
                @endif
            </div>

            <button type="button" class="btn btn-upload-photo"
                    onclick="document.getElementById('input-gambar-edit').click()">
                Ganti Foto
            </button>
            <div style="font-size: 11px; color: var(--text-muted); margin-top: 6px;">
                Pilih foto baru jika ingin mengganti. Biarkan kosong jika tidak ingin mengubah gambar.
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

        <form action="{{ route('seller.products.update', $product->id) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- input file hidden (single image) --}}
            <input type="file"
                   id="input-gambar-edit"
                   name="gambar"
                   class="d-none"
                   accept="image/*">

            <div class="seller-form-shell">
                {{-- NAMA PRODUK --}}
                <div class="seller-question-card">
                    <div class="seller-question-label">Nama Produk*</div>
                    <input type="text" name="nama_produk"
                           class="seller-input"
                           placeholder="Contoh: Diktat Dasar Pemrograman"
                           required
                           value="{{ old('nama_produk', $product->nama_produk) }}">
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
                              required>{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    <div class="seller-question-helper">
                        Tambahkan detail penting seperti kondisi, warna, ukuran, dll.
                    </div>
                </div>

                {{-- KATEGORI --}}
                <div class="seller-question-card">
                    <div class="seller-question-label">Kategori*</div>
                    <select name="category_id" class="seller-input" required>
                        <option value="">Pilih kategori</option>
                        <option value="1" {{ old('category_id', $product->category_id) == 1 ? 'selected' : '' }}>Kecantikan</option>
                        <option value="2" {{ old('category_id', $product->category_id) == 2 ? 'selected' : '' }}>Fashion</option>
                        <option value="3" {{ old('category_id', $product->category_id) == 3 ? 'selected' : '' }}>Elektronik</option>
                        <option value="4" {{ old('category_id', $product->category_id) == 4 ? 'selected' : '' }}>Rumah Tangga</option>
                        <option value="5" {{ old('category_id', $product->category_id) == 5 ? 'selected' : '' }}>Sport</option>
                        <option value="6" {{ old('category_id', $product->category_id) == 6 ? 'selected' : '' }}>Pendidikan</option>
                    </select>
                </div>

                {{-- STOK --}}
                <div class="seller-question-card">
                    <div class="seller-question-label">Stok*</div>
                    <input type="number" name="stok"
                           class="seller-input"
                           placeholder="Contoh: 10"
                           min="0" required
                           value="{{ old('stok', $product->stok) }}">
                </div>

                {{-- HARGA --}}
                <div class="seller-question-card">
                    <div class="seller-question-label">Harga*</div>
                    <input type="number" name="harga"
                           class="seller-input"
                           placeholder="Contoh: 35000"
                           min="0" required
                           value="{{ old('harga', $product->harga) }}">
                </div>

                <div class="text-center mt-2">
                    <button type="submit" class="seller-modal-btn">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const input   = document.getElementById('input-gambar-edit');
    const icon    = document.getElementById('edit-icon');
    const preview = document.getElementById('edit-preview');

    if (!input) return;

    input.addEventListener('change', function (e) {
        const file = e.target.files[0];

        if (!file) {
            // kalau batal pilih file, jangan ubah preview lama
            return;
        }

        const reader = new FileReader();
        reader.onload = function (ev) {
            if (preview) {
                preview.src = ev.target.result;
                preview.classList.remove('d-none');
            }
            if (icon) icon.classList.add('d-none');
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
