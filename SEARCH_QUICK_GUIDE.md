# 🔍 QUICK START GUIDE - Search Feature

## ⚡ Cara Cepat Menggunakan Fitur Search

### 1️⃣ **Akses Halaman History**
```
URL: http://127.0.0.1:8000/kasir/history
```

### 2️⃣ **Lihat Search Bar**
Setelah tabel "Detail Transaksi", Anda akan melihat search bar seperti ini:

```
┌─────────────────────────────────────────────────────────────────────┐
│  🔍  Cari berdasarkan nama pelanggan, kode member, atau kode...    │
└─────────────────────────────────────────────────────────────────────┘
```

### 3️⃣ **Ketik untuk Mencari**

**Contoh 1: Cari Nama Pelanggan**
```
Search: Ahmad
```
➡️ Akan menampilkan semua transaksi dari pelanggan yang namanya mengandung "Ahmad"

**Contoh 2: Cari Kode Member**
```
Search: MBR001
```
➡️ Akan menampilkan transaksi dari member dengan kode "MBR001"

**Contoh 3: Cari Kode Transaksi**
```
Search: TRX-20251105
```
➡️ Akan menampilkan transaksi dengan kode tersebut

### 4️⃣ **Melihat Hasil Pencarian**

Setelah mengetik, tunggu 500ms atau tekan **ENTER**, maka akan muncul:

```
Menampilkan hasil pencarian untuk: Ahmad  [✕ Hapus pencarian]
```

Dan tabel akan menampilkan hanya data yang sesuai.

### 5️⃣ **Menghapus Pencarian**

**Cara 1:** Klik tombol "✕ Hapus pencarian"
**Cara 2:** Hapus text di search bar (akan auto-clear setelah 500ms)

---

## 📊 Format Tampilan Tabel

### **Tanpa Member:**
```
| Pelanggan      |
|----------------|
| Umum           |
```

### **Dengan Member:**
```
| Pelanggan              |
|------------------------|
| Ahmad Pratama (MBR001) |
| Siti Nurhaliza (MBR002)|
```

---

## 🎯 Tips Penggunaan

✅ **DO:**
- Ketik minimal 3 karakter untuk hasil yang lebih akurat
- Gunakan nama lengkap atau sebagian nama
- Coba dengan kode jika nama tidak ditemukan
- Kombinasikan dengan filter periode untuk hasil spesifik

❌ **DON'T:**
- Jangan ketik terlalu cepat (biarkan auto-search bekerja)
- Jangan gunakan special character yang aneh
- Jangan lupa hapus pencarian sebelum filter periode baru

---

## 🔔 Notifikasi Visual

### **Saat Mencari:**
```
🔄 Loading... (Spinner muncul)
```

### **Hasil Ditemukan:**
```
✅ Menampilkan hasil pencarian untuk: [keyword]
   [✕ Hapus pencarian]

Menampilkan 1 - 5 dari 12 data
```

### **Tidak Ada Hasil:**
```
📭 Tidak Ada Data
Belum ada transaksi pada periode yang dipilih
```

---

## 🛠️ Troubleshooting Cepat

### **Problem: Pencarian tidak merespon**
**Solution:** 
- Refresh halaman (F5)
- Pastikan sudah login sebagai kasir
- Check browser console (F12) untuk error

### **Problem: Hasil tidak sesuai**
**Solution:** 
- Periksa ejaan keyword
- Coba dengan keyword yang lebih pendek
- Pastikan data ada dalam periode filter

### **Problem: Member code tidak muncul**
**Solution:** 
- Pastikan transaksi memiliki member
- Check database: member harus ada `member_code`
- Refresh dan coba lagi

---

## 📱 Keyboard Shortcuts

- **ENTER** → Execute search immediately
- **ESC** → Focus out dari search bar
- **Ctrl + A** → Select all text in search bar
- **Backspace** → Delete dan auto-search

---

## 🎨 Warna Indikator

- 🔵 **Biru** → Kode transaksi
- 🟢 **Hijau** → Total penjualan
- 🟣 **Ungu** → Jumlah item
- 🔴 **Merah** → Tombol hapus pencarian

---

## ✨ Fitur Tambahan

### **Auto-Complete (Future)**
Akan datang: Suggestion dropdown saat mengetik

### **Search History (Future)**
Akan datang: Menyimpan keyword pencarian terakhir

### **Advanced Filter (Future)**
Akan datang: Filter berdasarkan metode pembayaran, range harga, dll.

---

## 📞 Need Help?

Jika ada masalah atau pertanyaan:
1. Lihat dokumentasi lengkap di `SEARCH_FEATURE_DOCUMENTATION.md`
2. Check error di browser console (F12)
3. Lihat Laravel log: `storage/logs/laravel.log`

---

**Happy Searching! 🎉**
