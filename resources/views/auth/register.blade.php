<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <h2 class="text-xl font-bold mb-4">Akun User</h2>

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nama User" />
            <x-text-input id="name" class="block mt-1 w-full"
                type="text" name="name" value="{{ old('name') }}" required autofocus />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" value="Email User (untuk login)" />
            <x-text-input id="email" class="block mt-1 w-full"
                type="email" name="email" value="{{ old('email') }}" required />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full"
                type="password" name="password" required />
        </div>

        <!-- Confirm -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password" name="password_confirmation" required />
        </div>

        <hr class="my-6">

        <h2 class="text-xl font-bold mb-4">Data Seller</h2>

        <!-- Nama Toko -->
        <div>
            <x-input-label for="nama_toko" value="Nama Toko" />
            <x-text-input id="nama_toko" class="block mt-1 w-full"
                type="text" name="nama_toko" required />
        </div>

        <!-- Deskripsi Singkat -->
        <div class="mt-4">
            <x-input-label for="deskripsi_singkat" value="Deskripsi Singkat" />
            <textarea id="deskripsi_singkat" name="deskripsi_singkat"
                class="block mt-1 w-full border-gray-300 rounded-md">{{ old('deskripsi_singkat') }}</textarea>
        </div>

        <h2 class="text-lg font-semibold mt-6">Data PIC</h2>

        <div class="mt-4">
            <x-input-label for="nama_pic" value="Nama PIC" />
            <x-text-input id="nama_pic" class="block mt-1 w-full"
                type="text" name="nama_pic" required />
        </div>

        <div class="mt-4">
            <x-input-label for="no_hp" value="No HP PIC" />
            <x-text-input id="no_hp" class="block mt-1 w-full"
                type="text" name="no_hp" required />
        </div>

        <div class="mt-4">
            <x-input-label for="email_pic" value="Email PIC" />
            <x-text-input id="email_pic" class="block mt-1 w-full"
                type="email" name="email_pic" required />
        </div>

        <h2 class="text-lg font-semibold mt-6">Alamat</h2>

        <div class="mt-4">
            <x-input-label for="alamat_jalan" value="Nama Jalan" />
            <x-text-input id="alamat_jalan" class="block mt-1 w-full"
                type="text" name="alamat_jalan" required />
        </div>

        <div class="grid grid-cols-2 gap-4 mt-4">
            <div>
                <x-input-label for="rt" value="RT" />
                <x-text-input id="rt" class="block mt-1 w-full"
                    type="text" name="rt" required />
            </div>
            <div>
                <x-input-label for="rw" value="RW" />
                <x-text-input id="rw" class="block mt-1 w-full"
                    type="text" name="rw" required />
            </div>
        </div>


        {{-- PROVINSI --}}
        <div class="mt-4">
            <x-input-label value="Provinsi" />
            <select id="province_kode" name="province_kode" class="w-full border-gray-300 rounded-md" required>
                <option value="">-- Pilih Provinsi --</option>
                @foreach($provinces as $province)
                    <option value="{{ $province->kode }}">{{ $province->nama }}</option>
                @endforeach
            </select>
        </div>

        {{-- KABUPATEN / KOTA (awal kosong, diisi pakai AJAX) --}}
        <div class="mt-4">
            <x-input-label value="Kabupaten/Kota" />
            <select id="regency_kode" name="regency_kode" class="w-full border-gray-300 rounded-md" required>
                <option value="">-- Pilih Kabupaten/Kota --</option>
            </select>
        </div>

        {{-- KECAMATAN --}}
        <div class="mt-4">
            <x-input-label value="Kecamatan" />
            <select id="district_kode" name="district_kode" class="w-full border-gray-300 rounded-md" required>
                <option value="">-- Pilih Kecamatan --</option>
            </select>
        </div>

        {{-- KELURAHAN --}}
        <div class="mt-4">
            <x-input-label value="Kelurahan" />
            <select id="kelurahan" name="kelurahan" class="w-full border-gray-300 rounded-md" required>
                <option value="">-- Pilih Kelurahan --</option>
            </select>
        </div>


        <h2 class="text-lg font-semibold mt-6">KTP & Foto</h2>

        <div class="mt-4">
            <x-input-label for="no_ktp_pic" value="No KTP PIC" />
            <x-text-input id="no_ktp_pic" class="block mt-1 w-full"
                type="text" name="no_ktp_pic" required />
        </div>

        <div class="mt-4">
            <x-input-label for="foto_pic" value="Foto PIC" />
            <input type="file" id="foto_pic" name="foto_pic" accept="image/*" class="mt-1">
        </div>

        <div class="mt-4">
            <x-input-label for="file_ktp_pic" value="Upload KTP (gambar/pdf)" />
            <input type="file" id="file_ktp_pic" name="file_ktp_pic" class="mt-1">
        </div>

        <div class="flex justify-end mt-6">
            <x-primary-button>
                Register Seller
            </x-primary-button>
        </div>

    </form>

    @if ($errors->any())
        <div class="mb-4 text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



<script>
    // Saat provinsi berubah -> load kabupaten
    $('#province_kode').on('change', function() {
        let provinceKode = $(this).val();

        $('#regency_kode').html('<option value="">-- Pilih Kabupaten/Kota --</option>');
        $('#district_kode').html('<option value="">-- Pilih Kecamatan --</option>');
        $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');

        if (provinceKode) {
            $('#regency_kode').html('<option value="">Loading...</option>');
            $.get('/get-regencies/' + provinceKode, function(data) {
                let options = '<option value="">-- Pilih Kabupaten/Kota --</option>';
                data.forEach(function(r) {
                    options += `<option value="${r.kode}">${r.nama}</option>`;
                });
                $('#regency_kode').html(options);
            });
        }
    });

    // Saat kabupaten berubah -> load kecamatan
    $('#regency_kode').on('change', function() {
        let regencyKode = $(this).val();

        $('#district_kode').html('<option value="">-- Pilih Kecamatan --</option>');
        $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');

        if (regencyKode) {
            $('#district_kode').html('<option value="">Loading...</option>');
            $.get('/get-districts/' + regencyKode, function(data) {
                let options = '<option value="">-- Pilih Kecamatan --</option>';
                data.forEach(function(d) {
                    options += `<option value="${d.kode}">${d.nama}</option>`;
                });
                $('#district_kode').html(options);
            });
        }
    });

    // Saat kecamatan berubah -> load kelurahan
    $('#district_kode').on('change', function() {
        let districtKode = $(this).val();
        $('#kelurahan').html('<option value="">Loading...</option>');

        if (districtKode) {
            $.get('/get-villages/' + districtKode, function(data) {
                let options = '<option value="">-- Pilih Kelurahan --</option>';
                data.forEach(function(v) {
                    // value pakai nama kelurahan (masuk ke kolom "kelurahan" di tabel sellers)
                    options += `<option value="${v.nama}">${v.nama}</option>`;
                });
                $('#kelurahan').html(options);
            });
        } else {
            $('#kelurahan').html('<option value="">-- Pilih Kelurahan --</option>');
        }
    });
</script>



</x-guest-layout>
