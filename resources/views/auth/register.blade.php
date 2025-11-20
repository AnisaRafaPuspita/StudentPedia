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

        <div class="mt-4">
            <x-input-label for="kelurahan" value="Kelurahan" />
            <x-text-input id="kelurahan" class="block mt-1 w-full"
                type="text" name="kelurahan" required />
        </div>

        <div class="mt-4">
            <x-input-label value="Provinsi" />
            <select name="province_id" class="w-full border-gray-300 rounded-md" required>
                <option value="">-- Pilih Provinsi --</option>
                @foreach($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->Name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <x-input-label value="Kabupaten/Kota" />
            <select name="regency_id" class="w-full border-gray-300 rounded-md" required>
                <option value="">-- Pilih Kabupaten/Kota --</option>
                @foreach($regencies as $regency)
                    <option value="{{ $regency->id }}">{{ $regency->name }}</option>
                @endforeach
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
</x-guest-layout>
