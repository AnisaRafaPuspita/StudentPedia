<x-app-layout>
    <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Registrasi Seller Sedang Diproses</h1>

        <p class="mb-4">
            Terima kasih sudah mendaftar sebagai seller 🙌
        </p>

        <p class="mb-4">
            Status pendaftaran kamu saat ini:
            <span class="font-semibold capitalize">
                {{ $seller->status_verifikasi ?? 'pending' }}
            </span>
        </p>

        <p class="mb-4">
            Tim admin akan melakukan verifikasi data kamu terlebih dahulu.
            Hasil verifikasi (diterima / ditolak) akan dikirim melalui email PIC.
        </p>

        <p class="text-sm text-gray-600">
            Silakan cek email secara berkala. Jika belum menerima email dalam beberapa waktu,
            kamu bisa menghubungi admin sistem.
        </p>
    </div>
</x-app-layout>
