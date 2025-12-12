<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderasi Verifikasi Penjual - KampuSiapBelanja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-red-50 text-gray-800 font-sans antialiased">

    <div class="flex h-screen overflow-hidden">

        @include('Admin._sidebar', ['active' => 'verifikasi', 'verifCount' => $pendingSellers->count()])

        <!-- MAIN CONTENT -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-red-50 p-6 md:p-8">
            
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Verifikasi Calon Penjual</h2>
                    <p class="text-gray-500 text-sm mt-1">Tinjau kelengkapan dokumen dan validasi pendaftaran toko baru.</p>
                </div>
                
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                    {{ session('error') }}
                </div>
                @endif
            </div>

            <!-- List Card Container -->
            <div class="bg-white rounded-2xl shadow-sm border border-red-50 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-xs uppercase tracking-wider border-b border-gray-100">
                                <th class="p-5 font-semibold">Nama Calon / Toko</th>
                                <th class="p-5 font-semibold">Tanggal Daftar</th>
                                <th class="p-5 font-semibold">Status Dokumen</th>
                                <th class="p-5 font-semibold">Email</th>
                                <th class="p-5 font-semibold text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($pendingSellers as $seller)
                            <tr class="hover:bg-red-50/50 transition-colors">
                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                            {{ strtoupper(substr($seller->user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-800">{{ $seller->user->name }}</div>
                                            <div class="text-xs text-gray-500">Toko: "{{ $seller->shop_name }}"</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-5 text-sm text-gray-600">{{ $seller->created_at->format('d M Y, H:i') }}</td>
                                <td class="p-5">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                        Menunggu Review
                                    </span>
                                </td>
                                <td class="p-5 text-sm text-gray-600">{{ $seller->user->email }}</td>
                                <td class="p-5 text-right">
                                    <button 
                                        type="button"
                                        data-seller-id="{{ $seller->id }}"
                                        data-seller-name="{{ $seller->user->name }}"
                                        data-shop-name="{{ $seller->shop_name }}"
                                        data-seller-email="{{ $seller->user->email }}"
                                        class="review-btn bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm transition-colors cursor-pointer">
                                        Review
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">
                                    Tidak ada seller yang menunggu verifikasi.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="p-5 border-t border-gray-100 flex items-center justify-between">
                    <span class="text-sm text-gray-500">Menampilkan {{ $pendingSellers->count() }} data</span>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL VERIFIKASI -->
    <div id="verificationModal" style="display: none;"
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">

        <!-- Modal Content -->
        <div class="bg-white w-full max-w-4xl rounded-2xl shadow-2xl overflow-hidden transform transition-all"
             @click.away="closeModal()">
            
            <!-- Modal Header -->
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800">Verifikasi Data Penjual</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex flex-col md:flex-row h-[500px]">
                <!-- Left: Applicant Details -->
                <div class="w-full md:w-1/3 bg-white p-6 border-r border-gray-100 overflow-y-auto">
                    <div class="text-center mb-6">
                        <div id="modalInitials" class="w-20 h-20 bg-red-100 rounded-full mx-auto flex items-center justify-center text-red-500 text-2xl font-bold mb-3">BS</div>
                        <h4 id="modalName" class="font-bold text-gray-800 text-lg">-</h4>
                        <p id="modalEmail" class="text-sm text-gray-500">-</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Nama Toko</label>
                            <p id="modalShopName" class="text-sm font-medium text-gray-800">-</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Nomor HP</label>
                            <p class="text-sm font-medium text-gray-800">+62 812 3456 7890</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">Alamat Pickup</label>
                            <p class="text-sm text-gray-600">Jl. Kaliurang KM 5, Gg. Megatruh No. 12, Sleman, Yogyakarta.</p>
                        </div>
                        <div>
                            <label class="text-xs font-semibold text-gray-400 uppercase">NIM / ID Mahasiswa</label>
                            <p class="text-sm font-medium text-gray-800">19/445566/PA/12345</p>
                        </div>
                    </div>
                </div>

                <!-- Right: Document Checking -->
                <div class="w-full md:w-2/3 bg-gray-50 p-6 overflow-y-auto flex flex-col">
                    <h4 class="font-bold text-gray-800 mb-4">Kelengkapan Dokumen</h4>

                    <!-- State: Viewing Documents -->
                    <div x-show="!isRejecting">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Card KTM -->
                            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-bold text-gray-500 uppercase">Kartu Tanda Mahasiswa</span>
                                    <span class="text-green-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
                                </div>
                                <div class="h-32 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-sm border-2 border-dashed border-gray-300">
                                    [Preview Gambar KTM]
                                </div>
                                <button class="w-full mt-3 text-sm text-red-500 font-semibold hover:underline">Lihat Fullscreen</button>
                            </div>

                            <!-- Card KTP -->
                            <div class="bg-white p-4 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-xs font-bold text-gray-500 uppercase">KTP</span>
                                    <span class="text-green-500"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></span>
                                </div>
                                <div class="h-32 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-sm border-2 border-dashed border-gray-300">
                                    [Preview Gambar KTP]
                                </div>
                                <button class="w-full mt-3 text-sm text-red-500 font-semibold hover:underline">Lihat Fullscreen</button>
                            </div>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-100 rounded-lg p-4 text-sm text-yellow-800 mb-6">
                            <p class="font-bold flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Catatan Sistem
                            </p>
                            <p class="mt-1">Nama di KTP sesuai dengan nama di KTM. Status Mahasiswa Aktif.</p>
                        </div>
                    </div>

                    <!-- State: Rejecting (Form) -->
                    <div id="rejectForm" style="display: none;" class="flex-1 flex flex-col">
                        <div class="bg-red-50 border border-red-100 rounded-lg p-4 mb-4">
                            <h5 class="font-bold text-red-700 text-sm mb-2">Konfirmasi Penolakan</h5>
                            <p class="text-sm text-red-600 mb-4">Email penolakan akan dikirimkan ke pengguna. Mohon berikan alasan yang jelas agar pengguna dapat memperbaiki data.</p>
                            
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Alasan Penolakan</label>
                            <textarea id="rejectReason" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-400 focus:border-red-400 outline-none text-sm h-32" placeholder="Contoh: Foto KTM buram, Nama toko mengandung unsur SARA, dll..."></textarea>
                        </div>
                    </div>

                    <!-- Action Buttons Footer (Sticky Bottom) -->
                    <div class="mt-auto pt-4 border-t border-gray-200 flex justify-end gap-3">
                        
                        <!-- Buttons when VIEWING -->
                        <div id="viewButtons" class="flex gap-3 w-full justify-end">
                            <button onclick="startReject()" class="px-5 py-2.5 rounded-xl border border-red-200 text-red-600 font-semibold hover:bg-red-50 transition">
                                Tolak Pengajuan
                            </button>
                            <form id="approveForm" method="POST" class="inline-block">
                                @csrf
                                <button type="submit" class="px-5 py-2.5 rounded-xl bg-green-500 text-white font-semibold hover:bg-green-600 shadow-lg shadow-green-200 transition flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Terima & Aktivasi
                                </button>
                            </form>
                        </div>

                        <!-- Buttons when REJECTING -->
                        <div id="rejectButtons" style="display: none;" class="flex gap-3 w-full justify-end">
                            <button onclick="cancelReject()" class="px-5 py-2.5 rounded-xl text-gray-500 font-semibold hover:text-gray-700 transition">
                                Batal
                            </button>
                            <form id="rejectFormSubmit" method="POST" class="inline-block">
                                @csrf
                                <input type="hidden" name="rejection_reason" id="rejectReasonInput">
                                <button type="submit" id="rejectSubmitBtn" class="px-5 py-2.5 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 shadow-lg shadow-red-200 transition flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                    Kirim Email Penolakan
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logic Script -->
    <script>
        let currentSellerId = null;
        
        function openModal(name, shop, email, sellerId) {
            console.log('Opening modal:', {name, shop, email, sellerId});
            currentSellerId = sellerId;
            
            // Update modal content
            document.getElementById('modalName').textContent = name;
            document.getElementById('modalEmail').textContent = email;
            document.getElementById('modalShopName').textContent = shop;
            
            // Generate initials
            const initials = name.split(' ').map(n => n[0]).join('').substring(0,2).toUpperCase();
            document.getElementById('modalInitials').textContent = initials;
            
            // Update form actions
            document.getElementById('approveForm').action = `{{ url('/dashboard-admin/verifikasi') }}/${sellerId}/approve`;
            document.getElementById('rejectFormSubmit').action = `{{ url('/dashboard-admin/verifikasi') }}/${sellerId}/reject`;
            
            // Show modal
            document.getElementById('verificationModal').style.display = 'flex';
        }
        
        function closeModal() {
            document.getElementById('verificationModal').style.display = 'none';
            document.getElementById('rejectForm').style.display = 'none';
            document.getElementById('viewButtons').style.display = 'flex';
            document.getElementById('rejectButtons').style.display = 'none';
        }
        
        function startReject() {
            document.getElementById('rejectForm').style.display = 'flex';
            document.getElementById('viewButtons').style.display = 'none';
            document.getElementById('rejectButtons').style.display = 'flex';
        }
        
        function cancelReject() {
            document.getElementById('rejectForm').style.display = 'none';
            document.getElementById('viewButtons').style.display = 'flex';
            document.getElementById('rejectButtons').style.display = 'none';
        }
        
        // Handle reject form submission
        document.addEventListener('DOMContentLoaded', function() {
            const rejectTextarea = document.getElementById('rejectReason');
            const rejectInput = document.getElementById('rejectReasonInput');
            const rejectBtn = document.getElementById('rejectSubmitBtn');
            
            if (rejectTextarea && rejectInput) {
                rejectTextarea.addEventListener('input', function() {
                    rejectInput.value = this.value;
                    if (this.value.trim().length < 10) {
                        rejectBtn.disabled = true;
                        rejectBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    } else {
                        rejectBtn.disabled = false;
                        rejectBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                });
            }
            
            // Setup review buttons
            const buttons = document.querySelectorAll('.review-btn');
            console.log('Found', buttons.length, 'review buttons');
            
            buttons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const sellerId = this.dataset.sellerId;
                    const name = this.dataset.sellerName;
                    const shop = this.dataset.shopName;
                    const email = this.dataset.sellerEmail;
                    console.log('Button clicked:', {sellerId, name, shop, email});
                    openModal(name, shop, email, sellerId);
                });
            });
        });
    </script>
</body>
</html>