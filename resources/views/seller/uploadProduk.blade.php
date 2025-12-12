@extends('layouts.seller')

@section('seller-content')

<style>
    .form-block {
        background: #FFFFFF;
        border-radius: 18px;
        border: 1px solid #F9A8D4;
        box-shadow: 0 6px 18px rgba(255,45,122,0.10);
        margin-bottom: 18px;
        overflow: hidden;
    }
    .form-block-header {
        background: #FFEAF5;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 600;
        color: #9D174D;
        border-bottom: 1px solid #F9A8D4;
    }
    .form-block-body {
        padding: 14px 18px 18px;
    }
    .form-row {
        display: flex;
        align-items: flex-start;
        gap: 18px;
        margin-bottom: 10px;
    }
    .form-label {
        width: 160px;
        font-size: 12px;
        font-weight: 600;
        color: #9D174D;
        padding-top: 6px;
    }
    .form-field {
        flex: 1;
    }
    .form-helper {
        font-size: 11px;
        color: #6B7280;
        margin-top: 2px;
    }
    .radio-inline label {
        margin-right: 14px;
        font-size: 12px;
        color: #7F1D4B;
    }
    .radio-inline input {
        margin-right: 4px;
    }

    /* PREVIEW KOTAK BESAR */
    .upload-big-box {
        width: 260px;
        height: 260px;
        margin: 0 auto 12px;
        border-radius: 24px;
        border: 2px dashed #FF9CD1;
        background: #FFF5FA;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .upload-big-box .bi-image {
        font-size: 42px;
        color: #F9A8D4;
    }

    /* THUMBNAIL + TOMBOL PLUS */
    .upload-thumb {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid #F9A8D4;
        cursor: pointer;
        transition: box-shadow 0.15s ease, transform 0.15s ease, border-color 0.15s ease;
    }
    .upload-thumb.active {
        border-color: #FF2D7A !important;
        box-shadow: 0 0 0 2px rgba(255,45,122,0.35);
        transform: translateY(-1px);
    }

    .upload-plus-box {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        border: 1px dashed #F9A8D4;
        background: #FFF0F7;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        color: #FF2D7A;
        cursor: pointer;
        padding: 0;
    }
    .upload-plus-box:hover {
        background: #FFE4F5;
    }
</style>

{{-- HEADER --}}
<div class="seller-header-card">
    <div class="seller-header-left">
        <div class="seller-logo-circle">SP</div>
        <div>
            <div class="seller-header-title">Tambah Produk Baru</div>
            <div class="seller-header-subtitle">Lengkapi detail produk sebelum dipublikasikan</div>
        </div>
    </div>
    <div class="seller-header-right">
        <a href="{{ route('seller.dashboard') }}" class="btn-outline-grey">
            Kembali ke Dashboard
        </a>
    </div>
</div>

<div class="seller-products-card">

    {{-- INFO BAR --}}
    <div class="alert alert-info py-2 px-3 mb-3" style="font-size:12px; background:#F3F4FF; border-color:#BFDBFE; color:#1D4ED8;">
        Sebelum menambahkan produk, pastikan produk sudah sesuai dengan kebijakan StudentPedia dan tidak melanggar
        hak cipta ataupun aturan kampus.
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-1 px-2 mb-3" style="font-size:12px;">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('seller.products.store') }}"
          method="POST" enctype="multipart/form-data">
        @csrf

        {{-- wrapper untuk banyak input file --}}
        <div id="file-input-wrapper">
            <input type="file"
                   id="input-gambar-upload"
                   name="gambar[]"
                   class="d-none file-input"
                   accept="image/*"
                   multiple>
        </div>

        {{-- BLOK GAMBAR --}}
        <div class="form-block">
            <div class="form-block-header">
                Gambar Produk
            </div>
            <div class="form-block-body">

                <div class="seller-upload-header" style="margin-bottom:0; text-align:center;">

                    {{-- kotak besar --}}
                    <div class="upload-big-box">
                        <i class="bi bi-image" id="upload-icon"></i>
                        <img id="upload-preview" src="" class="upload-preview-img d-none">
                    </div>

                    {{-- tombol utama --}}
                    <button type="button" id="upload-main-btn" class="btn btn-upload-photo">
                        Upload Foto
                    </button>

                    <div class="form-helper mt-1">
                        Masukkan 1 foto atau lebih. Format JPG/PNG, maksimal 2MB per foto.
                    </div>

                    {{-- thumbnail --}}
                    <div id="upload-thumbs"
                         class="mt-3 d-flex justify-content-center gap-2 flex-wrap">
                    </div>

                    {{-- tombol plus untuk pilih foto tambahan --}}
                    <button type="button" id="addMorePhotoBtn" class="upload-plus-box mt-2">
                        +
                    </button>
                </div>

            </div>
        </div>

        {{-- BLOK 1: APA YANG KAMU JUAL --}}
        <div class="form-block">
            <div class="form-block-header">
                Apa yang kamu jual
            </div>
            <div class="form-block-body">

                {{-- Nama --}}
                <div class="form-row">
                    <div class="form-label">Nama Produk*</div>
                    <div class="form-field">
                        <input type="text" name="nama_produk" class="seller-input" required>
                        <div class="form-helper">Maksimal 70 karakter, tulis nama + jenis produk.</div>
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="form-row">
                    <div class="form-label">Kategori*</div>
                    <div class="form-field">
                        <select name="category_id" class="seller-input" required>
                            <option value="">Pilih Kategori</option>
                            <option value="1">Elektronik</option>
                            <option value="2">Fashion</option>
                            <option value="3">Kecantikan</option>
                            <option value="4">Rumah Tangga</option>
                            <option value="5">Sport</option>
                            <option value="6">Pendidikan</option>
                        </select>
                    </div>
                </div>

                {{-- Harga --}}
                <div class="form-row">
                    <div class="form-label">Harga*</div>
                    <div class="form-field">
                        <input type="number" name="harga" class="seller-input" required min="0">
                        <div class="form-helper">Masukkan harga satuan produk tanpa titik/koma.</div>
                    </div>
                </div>

                {{-- Stok --}}
                <div class="form-row">
                    <div class="form-label">Stok*</div>
                    <div class="form-field">
                        <input type="number" name="stok" class="seller-input" required min="0">
                    </div>
                </div>

                {{-- Kondisi --}}
                <div class="form-row">
                    <div class="form-label">Kondisi Barang*</div>
                    <div class="form-field radio-inline">
                        <label>
                            <input type="radio" name="kondisi" value="baru" checked> Baru
                        </label>
                        <label>
                            <input type="radio" name="kondisi" value="bekas"> Bekas
                        </label>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="form-row">
                    <div class="form-label">Deskripsi Produk*</div>
                    <div class="form-field">
                        <textarea name="deskripsi" class="seller-input seller-textarea" required></textarea>
                        <div class="form-helper">Isi dengan detail produk, bahan, ukuran, keunggulan, dsb.</div>
                    </div>
                </div>

            </div>
        </div>

        {{-- BLOK 2: VARIASI --}}
        <div class="form-block">
            <div class="form-block-header">
                Variasi Produk (opsional)
            </div>
            <div class="form-block-body">

                <div id="variation-container" class="d-flex flex-column gap-2">

                    {{-- Row Variasi Pertama --}}
                    <div class="variation-row d-flex gap-2 mb-1">
                        <select name="variation_type[]" class="seller-input" style="max-width:220px;">
                            <option value="">Tipe Variasi</option>
                            <option value="warna">Warna</option>
                            <option value="ukuran_sepatu">Ukuran Sepatu</option>
                            <option value="ukuran_baju">Ukuran Baju</option>
                        </select>

                        <input type="text" name="variation_value[]" class="seller-input"
                               placeholder="Contoh: Merah / M / 42">

                        <button type="button"
                                class="btn btn-danger btn-sm remove-variation d-none">
                            X
                        </button>
                    </div>
                </div>

                <button type="button" id="addVariationBtn"
                        class="btn btn-outline-secondary mt-2"
                        style="font-size:12px;border-radius:999px;">
                    + Tambah Variasi
                </button>

                <div class="form-helper mt-1">
                    Tambahkan beberapa baris jika produk punya lebih dari satu variasi.
                </div>
            </div>
        </div>

        {{-- SUBMIT --}}
        <div class="text-center mt-3">
            <button type="submit" class="seller-modal-btn">
                Upload Produk
            </button>
        </div>

    </form>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const fileWrapper = document.getElementById('file-input-wrapper');
    const mainInput   = document.getElementById('input-gambar-upload');
    const uploadBtn   = document.getElementById('upload-main-btn');
    const addMoreBtn  = document.getElementById('addMorePhotoBtn');

    const icon        = document.getElementById('upload-icon');
    const preview     = document.getElementById('upload-preview');
    const thumbs      = document.getElementById('upload-thumbs');

    // buat thumbnail + klik ganti preview
    function handleFiles(files) {
        if (!files || !files.length) return;

        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = (ev) => {
                const img = document.createElement('img');
                img.src   = ev.target.result;
                img.className = 'upload-thumb';

                img.onclick = () => {
                    document.querySelectorAll('.upload-thumb').forEach(t => t.classList.remove('active'));
                    img.classList.add('active');
                    preview.src = ev.target.result;
                    preview.classList.remove('d-none');
                    icon.classList.add('d-none');
                };

                thumbs.appendChild(img);

                // kalau belum ada preview sama sekali -> pakai yang pertama
                if (!preview.src) {
                    img.click();
                }
            };
            reader.readAsDataURL(file);
        });
    }

    function attachListener(input) {
        input.addEventListener('change', function(e){
            const files = e.target.files;
            handleFiles(files);
        });
    }

    attachListener(mainInput);

    // tombol "Upload Foto" pakai input pertama
    uploadBtn.addEventListener('click', () => {
        mainInput.click();
    });

    // tombol plus -> bikin input file baru, tetap name="gambar[]", jadi file lama nggak hilang
    addMoreBtn.addEventListener('click', () => {
        const newInput = mainInput.cloneNode();
        newInput.id    = '';      // biar nggak duplikat id
        newInput.value = '';      // reset
        fileWrapper.appendChild(newInput);
        attachListener(newInput);
        newInput.click();
    });

    // VARIASI
    const container = document.getElementById('variation-container');
    const addVarBtn = document.getElementById('addVariationBtn');

    if (addVarBtn && container) {
        addVarBtn.onclick = () => {
            const first = container.firstElementChild;
            if (!first) return;

            const newRow = first.cloneNode(true);
            newRow.querySelector('select').value = '';
            newRow.querySelector('input').value  = '';
            const rm = newRow.querySelector('.remove-variation');
            rm.classList.remove('d-none');
            rm.onclick = () => newRow.remove();
            container.append(newRow);
        };
    }
});
</script>
@endpush
