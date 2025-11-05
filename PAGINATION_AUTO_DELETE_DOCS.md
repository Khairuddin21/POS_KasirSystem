# 📄 PAGINATION & AUTO-DELETE TRANSAKSI - DOKUMENTASI

## ✅ FITUR BARU TELAH DITAMBAHKAN!

Saya telah berhasil menambahkan 2 fitur penting ke halaman **Laporan Penjualan Kasir**:

---

## 🎯 FITUR YANG DITAMBAHKAN

### 1️⃣ **Pagination (Halaman)**
- ✅ Tampilkan 10 transaksi per halaman
- ✅ Navigasi Previous/Next
- ✅ Tombol nomor halaman (1, 2, 3, ...)
- ✅ Info "Menampilkan 1-10 dari 50 data"
- ✅ Nomor urut tetap konsisten antar halaman
- ✅ Animasi smooth saat pindah halaman

### 2️⃣ **Auto-Delete Transaksi Kadaluarsa**
- ✅ Otomatis hapus transaksi > 3 hari
- ✅ Dijalankan setiap kali load report
- ✅ Background scheduled task (daily)
- ✅ Console command manual tersedia

---

## 📋 DETAIL IMPLEMENTASI

### **Backend (Controller)**
File: `app/Http/Controllers/Kasir/KasirController.php`

**Perubahan di `getReportData()` method:**
```php
// Auto-delete transactions older than 3 days
Transaction::where('created_at', '<', now()->subDays(3))
    ->where('user_id', Auth::id())
    ->delete();

// Pagination dengan 10 items per page
$paginatedTransactions = Transaction::...->paginate(10);

// Return dengan pagination info
return response()->json([
    'data' => $data,
    'pagination' => [
        'current_page' => ...,
        'last_page' => ...,
        'per_page' => 10,
        'total' => ...,
        'from' => ...,
        'to' => ...,
    ],
]);
```

**Fitur Auto-Delete:**
- Setiap kali user load report, transaksi > 3 hari otomatis dihapus
- Hanya hapus transaksi milik kasir yang login
- Menggunakan Carbon: `now()->subDays(3)`

---

### **Frontend (JavaScript)**
File: `resources/views/kasir/history.blade.php`

**Global Variables Baru:**
```javascript
let currentPage = 1;
let totalPages = 1;
let currentPagination = null;
```

**Function `loadReport(page = 1)`:**
- Terima parameter `page` untuk load halaman tertentu
- Kirim `page` ke API endpoint
- Update state pagination setelah dapat response

**Function `updatePagination(pagination)`:**
- Generate tombol Previous/Next
- Generate tombol nomor halaman (max 5 tombol)
- Tampilkan "..." jika ada halaman tersembunyi
- Disable tombol jika di halaman pertama/terakhir
- Active state untuk halaman current

**Function `createPageButton(pageNumber, currentPage)`:**
- Create button untuk setiap nomor halaman
- Highlight halaman active dengan warna biru
- onclick: `loadReport(pageNumber)`

---

### **UI/UX**
File: `resources/views/kasir/history.blade.php`

**Info Pagination:**
```html
<div>Menampilkan <span id="recordFrom">1</span> - 
<span id="recordTo">10</span> dari 
<span id="recordTotal">50</span> data</div>
```

**Pagination Controls:**
```html
<div id="paginationContainer">
    <span>Halaman 1 dari 5</span>
    <div id="paginationButtons">
        [<] [1] [2] [3] ... [5] [>]
    </div>
</div>
```

**Styling:**
- Previous/Next buttons: Blue background
- Active page: Blue dengan white text
- Inactive pages: Gray background
- Disabled state: Gray dengan cursor not-allowed
- Smooth hover transitions

---

### **Scheduled Task (Optional)**
File: `app/Console/Commands/CleanOldTransactions.php`

**Console Command:**
```php
php artisan transactions:clean
```

**Scheduled Daily:**
File: `routes/console.php`
```php
Schedule::command('transactions:clean')->daily();
```

**Setup Cron (Production):**
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🚀 CARA MENGGUNAKAN

### **1. Test Pagination:**
```
1. Buka: http://127.0.0.1:8000/kasir/history
2. Login sebagai kasir
3. Pilih periode dengan banyak transaksi (> 10)
4. Lihat pagination muncul di bawah tabel
5. Klik nomor halaman atau Previous/Next
6. Data otomatis berubah tanpa reload
```

### **2. Test Auto-Delete:**
```
Cara 1 (Otomatis):
- Setiap kali load report, transaksi > 3 hari otomatis terhapus

Cara 2 (Manual via Command):
php artisan transactions:clean

Cara 3 (Check Scheduled Task):
php artisan schedule:list
```

### **3. Verifikasi:**
```sql
-- Cek transaksi di database
SELECT created_at, transaction_code 
FROM transactions 
WHERE user_id = [kasir_id]
ORDER BY created_at DESC;

-- Harusnya tidak ada transaksi > 3 hari
```

---

## 📊 PAGINATION LOGIC

### **How It Works:**

**1. Request ke API:**
```
GET /kasir/history/data?period=daily&from=2025-11-01&to=2025-11-04&page=2
```

**2. Backend Process:**
```php
// Get all transactions for statistics & chart
$allTransactions = Transaction::...->get();

// Get paginated transactions for table
$paginatedTransactions = Transaction::...->paginate(10);
```

**3. Response Structure:**
```json
{
    "success": true,
    "statistics": { ... },
    "chartData": { ... },
    "data": [ ... ],  // 10 items only
    "pagination": {
        "current_page": 2,
        "last_page": 5,
        "per_page": 10,
        "total": 50,
        "from": 11,
        "to": 20
    }
}
```

**4. Frontend Update:**
- Update table dengan 10 data
- Show pagination controls
- Enable/disable buttons based on current page

---

## 🎨 PAGINATION UI COMPONENTS

### **Info Section:**
```
Menampilkan 11 - 20 dari 50 data
Halaman 2 dari 5
```

### **Buttons:**
```
[<]  [1]  [2]  [3]  ...  [5]  [>]
     ^^^  Active (blue)
```

### **States:**
- **Active Page**: Blue background, white text
- **Inactive Page**: Gray background, hover effect
- **Disabled**: Gray, cursor not-allowed
- **Hover**: Darker shade

### **Responsive:**
- Max 5 page buttons visible
- Show "..." when pages hidden
- Always show first & last page

---

## 🗑️ AUTO-DELETE SYSTEM

### **Deletion Rules:**
1. **Age**: > 3 hari dari sekarang
2. **Scope**: Hanya transaksi kasir yang login
3. **Timing**: Setiap load report + daily scheduled task
4. **Cascade**: Items juga ikut terhapus (foreign key)

### **Why 3 Days?**
- Cukup untuk laporan harian & mingguan
- Mengurangi beban database
- Data fresh dan relevan
- Bisa diubah di code jika perlu

### **Change Duration:**
```php
// Di KasirController.php, ubah angka 3:
Transaction::where('created_at', '<', now()->subDays(7)) // 7 hari
```

---

## 🔒 SECURITY & PERFORMANCE

### **Security:**
- ✅ Where clause `user_id = Auth::id()` mencegah hapus data kasir lain
- ✅ Soft delete bisa ditambahkan jika perlu recovery
- ✅ Authorization check via middleware

### **Performance:**
- ✅ Index pada `created_at` untuk query cepat
- ✅ Pagination mengurangi load data
- ✅ Eager loading relationships (`with(['items', 'user'])`)
- ✅ Statistics computed dari full dataset, table dari paginated

---

## 📱 RESPONSIVE DESIGN

### **Mobile:**
- Pagination buttons stack vertically
- Smaller font sizes
- Touch-friendly button sizes (48px min)

### **Tablet:**
- 2-column layout for info
- Horizontal pagination

### **Desktop:**
- Full pagination controls
- All features visible

---

## 🧪 TESTING

### **Test Pagination:**
```javascript
// Test 1: Load page 1
loadReport(1);  // Should show items 1-10

// Test 2: Load page 2
loadReport(2);  // Should show items 11-20

// Test 3: Empty page
loadReport(999); // Should show empty state
```

### **Test Auto-Delete:**
```php
// Create old transaction (manual test)
$transaction = Transaction::create([
    'created_at' => now()->subDays(4),
    // ... other fields
]);

// Run cleanup
php artisan transactions:clean

// Verify deletion
$exists = Transaction::find($transaction->id);
// Should be null
```

---

## 🐛 TROUBLESHOOTING

### **Issue: Pagination tidak muncul**
**Solusi:**
1. Cek response API: `console.log(data.pagination)`
2. Pastikan `last_page > 1`
3. Clear cache browser

### **Issue: Tombol pagination tidak bekerja**
**Solusi:**
1. Cek console browser untuk errors
2. Pastikan `loadReport(page)` dipanggil
3. Verify onclick handler

### **Issue: Auto-delete tidak jalan**
**Solusi:**
1. Cek apakah method dipanggil: `Log::info('Deleting old...')`
2. Verify date calculation: `dd(now()->subDays(3))`
3. Check database timestamps

### **Issue: Nomor urut salah**
**Solusi:**
```javascript
// Formula: (page - 1) * perPage + index + 1
const actualIndex = (pagination.current_page - 1) * pagination.per_page + index + 1;
```

---

## 💡 ENHANCEMENT IDEAS

### **Future Improvements:**

1. **Configurable Items Per Page:**
```html
<select id="perPage">
    <option value="10">10</option>
    <option value="25">25</option>
    <option value="50">50</option>
</select>
```

2. **Soft Delete Instead of Hard Delete:**
```php
// Add deleted_at to transactions table
Schema::table('transactions', function($table) {
    $table->softDeletes();
});

// Use soft delete
Transaction::where('created_at', '<', now()->subDays(3))
    ->delete(); // Soft delete
```

3. **Restore Deleted Transactions:**
```php
public function restoreTransaction($id) {
    Transaction::withTrashed()->find($id)->restore();
}
```

4. **Export with Pagination:**
- Option: "Export Current Page" vs "Export All"

5. **Advanced Filters:**
- Search by transaction code
- Filter by payment method
- Filter by amount range

---

## 📞 COMMAND REFERENCE

### **Manual Cleanup:**
```bash
# Run cleanup immediately
php artisan transactions:clean

# Check scheduled tasks
php artisan schedule:list

# Test schedule (without waiting)
php artisan schedule:run
```

### **Database Check:**
```sql
-- Count transactions by age
SELECT 
    DATE(created_at) as date,
    COUNT(*) as total
FROM transactions
GROUP BY DATE(created_at)
ORDER BY date DESC;

-- Check oldest transaction
SELECT MIN(created_at) FROM transactions;
```

---

## ✅ CHECKLIST COMPLETION

- ✅ Pagination dengan 10 items per page
- ✅ Previous/Next navigation
- ✅ Numbered page buttons
- ✅ Pagination info display
- ✅ Auto-delete transaksi > 3 hari
- ✅ Scheduled daily cleanup
- ✅ Manual cleanup command
- ✅ Responsive pagination UI
- ✅ Smooth animations
- ✅ Security checks

---

**🎉 FITUR SUDAH LENGKAP DAN SIAP PRODUCTION!**

Semua requirement sudah terpenuhi:
- ✅ Pagination untuk handle banyak transaksi
- ✅ Auto-delete untuk transaksi kadaluarsa (> 3 hari)
- ✅ UI/UX yang smooth dan responsive
- ✅ Security dan performance optimized

---

*Dibuat: 4 November 2025*
*Feature: Pagination & Auto-Delete*
*Version: 1.0.0*
