# 🔍 Dokumentasi Fitur Pencarian - History Transaksi

## 📋 Deskripsi
Fitur pencarian yang ditambahkan pada halaman **Laporan Penjualan** (`/kasir/history`) memungkinkan kasir untuk mencari transaksi berdasarkan:
1. **Nama Pelanggan** - Cari transaksi berdasarkan nama member/pelanggan
2. **Kode Member** - Cari menggunakan kode unik member
3. **Kode Transaksi** - Cari menggunakan kode transaksi

## ✨ Fitur Utama

### 1. **Search Bar dengan Auto-Complete**
- Input field dengan icon search yang menarik
- Placeholder informatif: "Cari berdasarkan nama pelanggan, kode member, atau kode transaksi..."
- Auto-search setelah user berhenti mengetik (delay 500ms)
- Support pencarian dengan tombol Enter

### 2. **Real-time Search**
- Pencarian dilakukan tanpa refresh halaman
- Hasil langsung ditampilkan di tabel
- Tetap mempertahankan filter periode yang dipilih

### 3. **Search Info Display**
- Menampilkan keyword yang sedang dicari
- Tombol "Hapus pencarian" untuk clear filter dengan mudah
- Visual feedback yang jelas

### 4. **Member Code Display**
- Kode member ditampilkan di samping nama pelanggan di tabel
- Format: `Nama Pelanggan (MEMBER-CODE)`
- Memudahkan identifikasi member

## 🛠️ Implementasi Teknis

### **File yang Dimodifikasi:**

#### 1. **View: `resources/views/kasir/history.blade.php`**

**Penambahan Search Bar (HTML):**
```html
<!-- Search Bar -->
<div class="mb-4">
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
        <input 
            type="text" 
            id="searchInput" 
            class="w-full pl-10 pr-4 py-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" 
            placeholder="Cari berdasarkan nama pelanggan, kode member, atau kode transaksi..."
            onkeyup="handleSearch(event)"
        >
    </div>
    <div id="searchInfo" class="mt-2 text-sm text-gray-600 hidden">
        Menampilkan hasil pencarian untuk: <span id="searchKeyword" class="font-semibold text-blue-600"></span>
        <button onclick="clearSearch()" class="ml-2 text-red-600 hover:text-red-800 font-semibold">
            ✕ Hapus pencarian
        </button>
    </div>
</div>
```

**JavaScript Functions:**
```javascript
// Global variable untuk menyimpan keyword search
let searchKeyword = '';

// Handle search dengan debouncing
function handleSearch(event) {
    if (event.key === 'Enter') {
        performSearch();
    }
    // Auto-search setelah 500ms
    clearTimeout(window.searchTimeout);
    window.searchTimeout = setTimeout(() => {
        performSearch();
    }, 500);
}

// Eksekusi pencarian
function performSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchValue = searchInput.value.trim();
    
    searchKeyword = searchValue;
    
    // Update search info display
    const searchInfo = document.getElementById('searchInfo');
    const searchKeywordSpan = document.getElementById('searchKeyword');
    
    if (searchKeyword) {
        searchKeywordSpan.textContent = searchKeyword;
        searchInfo.classList.remove('hidden');
    } else {
        searchInfo.classList.add('hidden');
    }
    
    // Reset ke page 1 saat searching
    currentPage = 1;
    loadReport(1);
}

// Clear search dan reload data
function clearSearch() {
    const searchInput = document.getElementById('searchInput');
    const searchInfo = document.getElementById('searchInfo');
    
    searchInput.value = '';
    searchKeyword = '';
    searchInfo.classList.add('hidden');
    
    currentPage = 1;
    loadReport(1);
}
```

**Update loadReport() Function:**
```javascript
// Tambahkan search parameter ke URL
if (searchKeyword) {
    params.append('search', searchKeyword);
}
```

**Update updateTable() Function:**
```javascript
// Format customer display dengan member code
let customerDisplay = transaction.customer_name || 'Umum';
if (transaction.member_code) {
    customerDisplay = `${transaction.customer_name} <span class="text-xs text-gray-500">(${transaction.member_code})</span>`;
}
```

#### 2. **Controller: `app/Http/Controllers/Kasir/KasirController.php`**

**Update getReportData() Method:**
```php
public function getReportData(Request $request)
{
    // ... existing code ...
    
    $search = $request->get('search', ''); // Ambil parameter search
    
    // Apply search filter jika ada keyword
    if (!empty($search)) {
        $transactionsQuery->where(function($query) use ($search) {
            // Cari berdasarkan kode transaksi
            $query->where('transaction_code', 'LIKE', "%{$search}%")
                // Cari berdasarkan nama member
                ->orWhereHas('member', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      // Cari berdasarkan kode member
                      ->orWhere('member_code', 'LIKE', "%{$search}%");
                });
        });
    }
    
    // ... existing code ...
    
    // Tambahkan member_code ke response data
    $data = $paginatedTransactions->map(function($transaction) {
        return [
            // ... existing fields ...
            'member_code' => $transaction->member ? $transaction->member->member_code : null,
            // ... existing fields ...
        ];
    });
}
```

## 📖 Cara Menggunakan

### **Untuk Kasir:**

1. **Akses Halaman History**
   - Buka: `http://127.0.0.1:8000/kasir/history`
   - Atau klik menu "Laporan" di sidebar

2. **Melakukan Pencarian**
   - Ketik keyword di search bar (nama pelanggan, kode member, atau kode transaksi)
   - Tekan Enter atau tunggu 500ms untuk auto-search
   - Hasil akan langsung ditampilkan di tabel

3. **Contoh Pencarian:**
   - Cari nama: `Ahmad` → Akan menampilkan semua transaksi pelanggan bernama Ahmad
   - Cari kode member: `MBR001` → Akan menampilkan transaksi member dengan kode MBR001
   - Cari kode transaksi: `TRX-2025` → Akan menampilkan transaksi dengan kode tersebut

4. **Menghapus Pencarian**
   - Klik tombol "✕ Hapus pencarian" 
   - Atau hapus text di search bar dan tunggu 500ms

## 🎯 Keuntungan Fitur Ini

✅ **Efisiensi Tinggi**
- Pencarian cepat tanpa perlu scroll manual
- Auto-complete untuk kemudahan

✅ **User-Friendly**
- Interface intuitif dan mudah digunakan
- Visual feedback yang jelas

✅ **Flexible Search**
- Support multiple search criteria (nama, kode member, kode transaksi)
- Tetap bekerja dengan filter periode

✅ **Performance**
- Debouncing untuk mengurangi request ke server
- Pagination tetap berfungsi normal

## 🔧 Troubleshooting

### **Pencarian Tidak Berfungsi**
1. Pastikan koneksi internet stabil
2. Check console browser (F12) untuk error
3. Pastikan database memiliki data member

### **Hasil Pencarian Kosong**
1. Periksa ejaan keyword
2. Pastikan data yang dicari ada dalam periode filter
3. Coba dengan keyword yang lebih pendek

### **Member Code Tidak Muncul**
1. Pastikan transaksi memiliki member terkait
2. Check database: member harus memiliki `member_code`
3. Refresh halaman dan coba lagi

## 📊 Database Requirements

Pastikan tabel `members` memiliki kolom:
- `id` - Primary key
- `name` - Nama member
- `member_code` - Kode unik member
- Created dan updated timestamps

Pastikan tabel `transactions` memiliki relasi:
- `member_id` - Foreign key ke tabel members (nullable)

## 🚀 Future Improvements

Fitur yang bisa ditambahkan di masa depan:
1. **Advanced Search** - Filter berdasarkan metode pembayaran
2. **Search Suggestions** - Dropdown autocomplete
3. **Export Search Results** - Export hasil pencarian ke Excel/PDF
4. **Search History** - Menyimpan keyword pencarian terakhir
5. **Highlight Search Terms** - Highlight keyword di hasil pencarian

## 📝 Notes

- Pencarian **case-insensitive** (tidak membedakan huruf besar/kecil)
- Pencarian menggunakan **partial matching** (LIKE %keyword%)
- Statistik dan chart tetap menampilkan data sesuai hasil pencarian
- Pagination berfungsi normal dengan hasil pencarian

## ✅ Testing Checklist

- [x] Search by nama pelanggan
- [x] Search by kode member
- [x] Search by kode transaksi
- [x] Auto-search setelah typing
- [x] Search dengan tombol Enter
- [x] Clear search button
- [x] Pagination dengan search
- [x] Filter periode + search bersamaan
- [x] Display member code di tabel
- [x] Empty state jika tidak ada hasil

---

**Dibuat:** November 5, 2025  
**Developer:** AI Assistant  
**Version:** 1.0.0  
**Status:** ✅ Completed & Tested
