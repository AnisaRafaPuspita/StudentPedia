<x-guest-layout>
    <form method="POST" action="#">
        @csrf

        <!-- Nama Toko -->
        <div>
            <x-input-label value="Nama Toko" />
            <x-text-input name="nama_toko" class="block mt-1 w-full" required />
        </div>

        <!-- Nama PIC -->
        <div class="mt-4">
            <x-input-label value="Nama PIC" />
            <x-text-input name="nama_pic" class="block mt-1 w-full" required />
        </div>

        <!-- Provinsi -->
        <div class="mt-4">
            <x-input-label for="province_id" value="Provinsi" />
            <select id="province_id" name="province_id" class="block mt-1 w-full">
                <option value="">-- Pilih Provinsi --</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Kabupaten / Kota -->
        <div class="mt-4">
            <x-input-label for="regency_id" value="Kabupaten / Kota" />
            <select id="regency_id" name="regency_id" class="block mt-1 w-full">
                <option value="">-- Pilih Kabupaten --</option>
            </select>
        </div>

        <div class="mt-6">
            <x-primary-button>
                Daftar Seller
            </x-primary-button>
        </div>

    </form>

    <!-- SCRIPT DROPDOWN -->
    <script>
        document.getElementById('province_id').addEventListener('change', function() {
            let provinceId = this.value;

            fetch('/get-regencies/' + provinceId)
                .then(response => response.json())
                .then(data => {
                    let regencySelect = document.getElementById('regency_id');
                    regencySelect.innerHTML = '<option value="">-- Pilih Kabupaten --</option>';

                    data.forEach(regency => {
                        let option = document.createElement('option');
                        option.value = regency.id;
                        option.textContent = regency.name;
                        regencySelect.appendChild(option);
                    });
                });
        });
    </script>
</x-guest-layout>
