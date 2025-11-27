<x-app-layout>
    <div class="max-w-6xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Platform - Verifikasi Seller</h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">
                Logout
            </button>
        </form>


        {{-- Flash message --}}
        @if (session('status'))
            <div class="mb-4 px-4 py-2 rounded bg-green-100 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-left border-b">Nama Toko</th>
                        <th class="px-3 py-2 text-left border-b">PIC</th>
                        <th class="px-3 py-2 text-left border-b">Email PIC</th>
                        <th class="px-3 py-2 text-left border-b">Status</th>
                        <th class="px-3 py-2 text-left border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sellers as $seller)
                        <tr class="border-b">
                            <td class="px-3 py-2">{{ $seller->nama_toko }}</td>
                            <td class="px-3 py-2">{{ $seller->nama_pic }}</td>
                            <td class="px-3 py-2">
                                {{ $seller->email_pic ?? $seller->email }}
                            </td>
                            <td class="px-3 py-2">
                                @if ($seller->status_verifikasi === 'pending')
                                    <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                @elseif ($seller->status_verifikasi === 'approved')
                                    <span class="px-2 py-1 rounded bg-green-100 text-green-800">
                                        Approved
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded bg-red-100 text-red-800">
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-3 py-2">
                                @if ($seller->status_verifikasi === 'pending')
                                    <form action="{{ route('platform.sellers.approve', $seller) }}"
                                          method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 rounded bg-green-600 text-white hover:bg-green-700">
                                            Approve
                                        </button>
                                    </form>

                                    <form action="{{ route('platform.sellers.reject', $seller) }}"
                                          method="POST" class="inline ml-2">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700">
                                            Reject
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-500 text-xs">
                                        Sudah diverifikasi
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-3 py-4 text-center text-gray-500" colspan="5">
                                Belum ada seller.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $sellers->links() }}
        </div>
    </div>
</x-app-layout>
