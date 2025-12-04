@extends('layouts.seller')

@section('seller-content')

{{-- STYLE BLOK SAMA SEPERTI CREATE (TOKPED FEEL) --}}
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
    .thumb-wrapper {
        position: relative;
        display: inline-block;
    }
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

    .thumb-delete-btn {
        position: absolute;
        top: -6px;
        right: -6px;
        width: 18px;
        height: 18px;
        border-radius: 999px;
        border: none;
        background: #F97373;
        color: #fff;
        font-size: 11px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        line-height: 1;
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
            <div class="seller-header-title">Edit Produk</div>
            <div class="seller-header-subtitle">Update informasi produkmu di StudentPedia</div>
        </div>
    </div>
    <div class="seller-header-right">
        <a href="{{ route('seller.dashboard') }}" class="btn-outline-grey">
            Kembali ke Dashboard
        </a>
    </div>
</div>

<div class="seller-products-card">

    {{-- INFO BAR KECIL --}}
    <div class="alert alert-warning py-2 px-3 mb-3"
         style="font-size:12px; background:#FFF7FB; border-color:#F9A8D4; color:#9D174D;">
        Pastikan data produk sudah benar sebelum disimpan.
        Foto baru bersifat opsional — jika tidak diubah, foto lama tetap dipakai.
    </div>

    @if($errors->any())
        <div class="alert alert-danger py-1 px-2 mb-3" style="font-size:12px;">
            @foreach($errors->all() as $err)
                <div>{{ $err }}</div>
            @endforeach
        </div>
    @endif

    @php
        /**
         * Kumpulkan semua gambar lama UNTUK EDIT:
         * - Kalau relasi images ada, pakai ITU SAJA
         * - Kalau tidak ada, fallback ke field gambar utama
         * Biar nggak dobel lagi.
         */
        $thumbSources = collect();

        if ($product->images && $product->images->count() > 0) {
            foreach ($product->images as $img) {
                $thumbSources->push([
                    'id'  => $img->id,
                    'src' => asset('storage/'.$img->path),
                ]);
            }
        } elseif ($product->gambar) {
            $thumbSources->push([
                'id'  => null,
                'src' => asset('storage/'.$product->gambar),
            ]);
        }

        $firstThumb = $thumbSources->first();
    @endphp

    <form action="{{ route('seller.products.update',$product->id) }}"
          method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- wrapper untuk banyak input file --}}
        <div id="file-input-wrapper">
            <input type="file"
                   id="input-gambar-edit"
                   name="gambar[]"
                   class="d-none file-input-edit"
                   accept=".jpg,.jpeg,.png">
        </div>

        {{-- tempat hidden input ID gambar yang dihapus --}}
        <div id="deleted-images-container"></div>

        {{-- BLOK GAMBAR --}}
        <div class="form-block">
            <div class="form-block-header">
                Gambar Produk
            </div>
            <div class="form-block-body">

                <div class="seller-upload-header" style="margin-bottom:0; text-align:center;">

                    {{-- kotak besar --}}
                    <div class="upload-big-box">
                        @if($firstThumb)
                            <img id="edit-preview"
                                 src="{{ $firstThumb['src'] }}"
                                 class="upload-preview-img">
                            <i id="edit-icon" class="bi bi-image d-none"></i>
                        @else
                            <i id="edit-icon" class="bi bi-image"></i>
                            <img id="edit-preview"
                                 src=""
                                 class="upload-preview-img d-none">
                        @endif
                    </div>

                    {{-- tombol utama --}}
                    <button type="button" id="upload-main-btn" class="btn btn-upload-photo">
                        Ganti Foto
                    </button>

                    <div class="form-helper mt-1">
                        Tambah atau ganti foto JPG/PNG (maks 2MB per foto).
                        Jika tidak memilih foto baru, foto yang sekarang akan tetap digunakan.
                    </div>

                    {{-- thumbnail lama --}}
                    <div id="upload-thumbs"
                         class="mt-3 d-flex justify-content-center gap-2 flex-wrap">
                        @foreach($thumbSources as $item)
                            <div class="thumb-wrapper">
                                <img src="{{ $item['src'] }}"
                                     class="upload-thumb {{ $loop->first ? 'active' : '' }}">
                                @if($item['id'])
                                    <button type="button"
                                            class="thumb-delete-btn"
                                            data-id="{{ $item['id'] }}">×</button>
                                @endif
                            </div>
                        @endforeach
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
                        <input type="text" name="nama_produk"
                               value="{{ $product->nama_produk }}"
                               class="seller-input" required>
                        <div class="form-helper">Maksimal 70 karakter, cantumkan jenis & merek produk.</div>
                    </div>
                </div>

                {{-- Kategori --}}
                <div class="form-row">
                    <div class="form-label">Kategori*</div>
                    <div class="form-field">
                        <select name="category_id" class="seller-input" required>
                            <option value="1" {{ $product->category_id==1?'selected':'' }}>Kecantikan</option>
                            <option value="2" {{ $product->category_id==2?'selected':'' }}>Fashion</option>
                            <option value="3" {{ $product->category_id==3?'selected':'' }}>Elektronik</option>
                            <option value="4" {{ $product->category_id==4?'selected':'' }}>Rumah Tangga</option>
                            <option value="5" {{ $product->category_id==5?'selected':'' }}>Sport</option>
                            <option value="6" {{ $product->category_id==6?'selected':'' }}>Pendidikan</option>
                        </select>
                    </div>
                </div>

                {{-- Harga --}}
                <div class="form-row">
                    <div class="form-label">Harga*</div>
                    <div class="form-field">
                        <input type="number" name="harga" min="0"
                               value="{{ $product->harga }}"
                               class="seller-input" required>
                        <div class="form-helper">Masukkan harga satuan produk (tanpa titik/koma).</div>
                    </div>
                </div>

                {{-- Stok --}}
                <div class="form-row">
                    <div class="form-label">Stok*</div>
                    <div class="form-field">
                        <input type="number" name="stok" min="0"
                               value="{{ $product->stok }}"
                               class="seller-input" required>
                    </div>
                </div>

                {{-- Kondisi --}}
                <div class="form-row">
                    <div class="form-label">Kondisi Barang*</div>
                    <div class="form-field radio-inline">
                        <label>
                            <input type="radio" name="kondisi" value="baru"
                                   {{ $product->kondisi == 'baru' ? 'checked' : '' }}>
                            Baru
                        </label>
                        <label>
                            <input type="radio" name="kondisi" value="bekas"
                                   {{ $product->kondisi == 'bekas' ? 'checked' : '' }}>
                            Bekas
                        </label>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="form-row">
                    <div class="form-label">Deskripsi Produk*</div>
                    <div class="form-field">
                        <textarea name="deskripsi"
                                  class="seller-input seller-textarea"
                                  required>{{ $product->deskripsi }}</textarea>
                        <div class="form-helper">Tuliskan detail produk, bahan, ukuran, atau cara pakai.</div>
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
                    @php $variations = $product->variations ?? collect(); @endphp

                    @forelse($variations as $var)
                        <div class="variation-row d-flex gap-2 mb-1">
                            <select name="variation_type[]" class="seller-input" style="max-width:220px;">
                                <option value="">Tipe Variasi</option>
                                <option value="warna"         {{ $var->type=='warna'?'selected':'' }}>Warna</option>
                                <option value="ukuran_sepatu" {{ $var->type=='ukuran_sepatu'?'selected':'' }}>Ukuran Sepatu</option>
                                <option value="ukuran_baju"   {{ $var->type=='ukuran_baju'?'selected':'' }}>Ukuran Baju</option>
                            </select>

                            <input type="text" name="variation_value[]"
                                   value="{{ $var->value }}"
                                   class="seller-input"
                                   placeholder="Contoh: Merah / 38 / M">

                            <button type="button"
                                    class="btn btn-danger btn-sm remove-variation">
                                X
                            </button>
                        </div>
                    @empty
                        <div class="variation-row d-flex gap-2 mb-1">
                            <select name="variation_type[]" class="seller-input" style="max-width:220px;">
                                <option value="">Tipe Variasi</option>
                                <option value="warna">Warna</option>
                                <option value="ukuran_sepatu">Ukuran Sepatu</option>
                                <option value="ukuran_baju">Ukuran Baju</option>
                            </select>

                            <input type="text" name="variation_value[]"
                                   class="seller-input"
                                   placeholder="Contoh: Merah / 38 / M">

                            <button type="button"
                                    class="btn btn-danger btn-sm remove-variation d-none">
                                X
                            </button>
                        </div>
                    @endforelse
                </div>

                <button type="button" id="addVariationBtn"
                        class="btn btn-outline-secondary mt-2"
                        style="font-size:12px;border-radius:999px;">
                    + Tambah Variasi
                </button>

                <div class="form-helper mt-1">
                    Contoh variasi: warna (Merah, Biru), ukuran baju (S, M, L), ukuran sepatu (38, 39, 40).
                </div>
            </div>
        </div>

        {{-- SUBMIT --}}
        <div class="text-center mt-3">
            <button type="submit" class="seller-modal-btn">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const fileWrapper  = document.getElementById('file-input-wrapper');
    const mainInput    = document.getElementById('input-gambar-edit');
    const uploadBtn    = document.getElementById('upload-main-btn');
    const addMoreBtn   = document.getElementById('addMorePhotoBtn');
    const deletedWrap  = document.getElementById('deleted-images-container');

    const icon    = document.getElementById('edit-icon');
    const preview = document.getElementById('edit-preview');
    const thumbs  = document.getElementById('upload-thumbs');

    // klik thumbnail -> ganti preview besar
    function bindThumbClick(img) {
        img.addEventListener('click', () => {
            document.querySelectorAll('#upload-thumbs .upload-thumb').forEach(t => t.classList.remove('active'));
            img.classList.add('active');
            preview.src = img.src;
            preview.classList.remove('d-none');
            if (icon) icon.classList.add('d-none');
        });
    }

    // klik tombol hapus -> tandai untuk dihapus & remove dari UI
    function bindDeleteBtn(btn) {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const id = btn.dataset.id;
            const wrapper = btn.closest('.thumb-wrapper');
            const img = wrapper ? wrapper.querySelector('.upload-thumb') : null;
            const wasActive = img && img.classList.contains('active');

            // tambahkan hidden input deleted_images[]
            if (id && deletedWrap) {
                const hidden = document.createElement('input');
                hidden.type  = 'hidden';
                hidden.name  = 'deleted_images[]';
                hidden.value = id;
                deletedWrap.appendChild(hidden);
            }

            if (wrapper) wrapper.remove();

            // kalau yang dihapus itu yang lagi dipreview -> pindah ke thumbnail lain
            if (wasActive) {
                const firstThumb = document.querySelector('#upload-thumbs .upload-thumb');
                if (firstThumb) {
                    firstThumb.click();
                } else {
                    preview.src = '';
                    preview.classList.add('d-none');
                    if (icon) icon.classList.remove('d-none');
                }
            }
        });
    }

    // inisialisasi thumbnail lama
    document.querySelectorAll('#upload-thumbs .upload-thumb').forEach(img => {
        bindThumbClick(img);
    });
    document.querySelectorAll('.thumb-delete-btn').forEach(btn => {
        bindDeleteBtn(btn);
    });

    // kalau sudah ada preview awal, sembunyikan icon
    if (preview && preview.src && preview.src !== window.location.href) {
        if (icon) icon.classList.add('d-none');
    }

    // buat thumbnail baru dari file yang dipilih
    function handleFiles(files) {
        if (!files || !files.length) return;

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = (ev) => {
                const wrapper = document.createElement('div');
                wrapper.className = 'thumb-wrapper';

                const img = document.createElement('img');
                img.src   = ev.target.result;
                img.className = 'upload-thumb';

                wrapper.appendChild(img);
                thumbs.appendChild(wrapper);

                bindThumbClick(img);

                // kalau belum ada preview sama sekali -> pakai yang pertama
                if (!preview.src || preview.classList.contains('d-none')) {
                    img.click();
                }
            };
            reader.readAsDataURL(file);
        });
    }

    function attachListener(input) {
        input.addEventListener('change', function(e){
            handleFiles(e.target.files);
        });
    }

    if (mainInput) {
        attachListener(mainInput);

        uploadBtn.addEventListener('click', () => {
            mainInput.click();
        });

        // tombol plus -> bikin input file baru (name tetap gambar[])
        addMoreBtn.addEventListener('click', () => {
            const newInput = mainInput.cloneNode();
            newInput.id    = '';   // jangan duplikat id
            newInput.value = '';
            fileWrapper.appendChild(newInput);
            attachListener(newInput);
            newInput.click();
        });
    }

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

        container.querySelectorAll('.remove-variation').forEach(btn => {
            btn.onclick = () => btn.parentElement.remove();
        });
    }
});
</script>
@endpush
