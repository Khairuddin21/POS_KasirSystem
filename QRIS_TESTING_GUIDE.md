# 🧪 QRIS Payment - Quick Testing Guide

## ⚡ Fast Testing Steps

### 1️⃣ **Login sebagai Kasir**
```
URL: http://127.0.0.1:8000/login
Email: kasir@example.com (atau kasir account Anda)
Password: your_password
```

### 2️⃣ **Akses Kasir Dashboard**
```
URL: http://127.0.0.1:8000/kasir
```

### 3️⃣ **Test QRIS Flow**

#### A. Add Products to Cart
1. Pilih kategori (atau ALL)
2. Klik produk untuk add to cart
3. Lihat cart terisi (kanan sidebar)

#### B. Select QRIS Payment
1. Scroll ke bagian "Metode Pembayaran"
2. Klik button **📱 QRIS**
3. **Expected Results**:
   - ✅ Button QRIS active (blue gradient background)
   - ✅ Text menjadi putih
   - ✅ Section "Uang Dibayar" dan "Kembalian" **HILANG**
   - ✅ Button "Bayar (F4)" menjadi **ENABLED** (tidak disabled)
   - ✅ Notification muncul: "💳 Pilih QRIS - Langsung klik Bayar untuk scan QR Code"

#### C. Click "Bayar (F4)"
1. Klik button biru "Bayar (F4)"
2. **Expected Results**:
   - ✅ Modal popup muncul dengan smooth animation
   - ✅ Header biru: "📱 Pembayaran QRIS"
   - ✅ QR Code image tampil (dari `/images/payment/qris.jpg`)
   - ✅ Total belanja tampil (Rp X.XXX)
   - ✅ Kode transaksi tampil (TRX-{timestamp})
   - ✅ Tanggal tampil
   - ✅ Instruksi 5 steps visible
   - ✅ 2 buttons: "Batal" (grey) dan "Konfirmasi Pembayaran" (green)

#### D. Test Modal Actions
1. **Test Cancel**: 
   - Klik "Batal" → Modal tertutup
   - Klik "Bayar (F4)" lagi untuk reopen
   
2. **Test Close Button**:
   - Klik ✕ di kanan atas → Modal tertutup

3. **Test Confirm**:
   - Klik "Konfirmasi Pembayaran"
   - **Expected Results**:
     - ✅ Modal tertutup
     - ✅ Loading spinner muncul pada button "Bayar"
     - ✅ Request sent ke backend
     - ✅ Success modal muncul setelah ~500ms
     - ✅ Success modal shows:
       - Checkmark animation ✅
       - Transaction code
       - Date & time
       - Total, Paid, Change (Rp 0)
       - Member info (jika ada)

#### E. Verify Success
1. Success modal should display:
   - ✅ Transaction processed
   - ✅ Paid amount = Total amount
   - ✅ Change = Rp 0 (no change for QRIS)
   - ✅ Member points updated (jika member selected)

2. Close success modal:
   - Klik "OK" atau close button
   - Cart cleared
   - Ready untuk transaksi baru

---

### 4️⃣ **Test TUNAI Flow (Comparison)**

#### A. Select Cash Payment
1. Add products to cart lagi
2. Klik button **💵 TUNAI**
3. **Expected Results**:
   - ✅ Button TUNAI active (blue gradient)
   - ✅ Section "Uang Dibayar" tampil
   - ✅ Section "Kembalian" tampil
   - ✅ Button "Bayar (F4)" **DISABLED** (sampai input valid)

#### B. Input Payment
1. Input uang dibayar (harus >= total)
2. **Expected Results**:
   - ✅ Kembalian calculated otomatis
   - ✅ Button "Bayar (F4)" enabled

#### C. Process Payment
1. Klik "Bayar (F4)"
2. **Expected Results**:
   - ✅ Langsung process (NO modal)
   - ✅ Success modal muncul
   - ✅ Change displayed (jika ada)

---

### 5️⃣ **Test Switching Between Methods**

#### A. Cash → QRIS
1. Cart ada items
2. Pilih TUNAI
3. Input uang dibayar
4. Switch ke QRIS
5. **Expected Results**:
   - ✅ Cash input hidden
   - ✅ Button enabled
   - ✅ Notification muncul

#### B. QRIS → Cash
1. Cart ada items
2. Pilih QRIS
3. Switch ke TUNAI
4. **Expected Results**:
   - ✅ Cash input shown
   - ✅ Button disabled (until input)
   - ✅ Input cleared

---

## 🔍 Visual Inspection Checklist

### Payment Buttons
- [ ] 2 buttons side by side (grid-cols-2)
- [ ] Large card style (min-height: 120px)
- [ ] Icon centered (💵 📱)
- [ ] Bold label text
- [ ] Subtitle text (smaller, grey)
- [ ] Hover effect (scale + blue background)
- [ ] Active state (blue gradient + white text)

### QRIS Modal
- [ ] Backdrop blur (dark overlay)
- [ ] Modal centered
- [ ] Blue gradient header
- [ ] Close button (✕) kanan atas
- [ ] QR image (centered, border)
- [ ] Transaction details (blue bg box)
- [ ] Yellow instruction box (warning style)
- [ ] 2 buttons (Batal grey, Konfirmasi green)
- [ ] Smooth animation (fade + zoom)

### Cash Input Section
- [ ] Label "Uang Dibayar"
- [ ] Input dengan "Rp" prefix
- [ ] Green kembalian box
- [ ] Hidden when QRIS selected
- [ ] Shown when TUNAI selected

---

## 🐛 Common Issues to Check

### Issue 1: Cash input tidak hilang saat QRIS
**Check**:
- Console errors?
- `#cashInputSection` element exists?
- `selectPaymentMethod()` function called?

### Issue 2: QR modal tidak muncul
**Check**:
- `#qrisModal` element exists?
- `.modal-overlay.show` class applied?
- CSS: `.modal-overlay.show { display: flex; }` exists?

### Issue 3: Button tidak enable untuk QRIS
**Check**:
- Cart has items? (`cart.length > 0`)
- `processBtn.disabled = false` executed?
- Opacity classes removed?

### Issue 4: QR image tidak tampil
**Check**:
- File exists: `public/images/payment/qris.jpg`
- Path correct: `/images/payment/qris.jpg`
- Image readable (not corrupted)

---

## 📊 Database Verification

### After QRIS Transaction
```sql
-- Check latest transaction
SELECT 
    transaction_code,
    payment_method,
    total,
    paid,
    `change`,
    created_at
FROM transactions
ORDER BY created_at DESC
LIMIT 1;

-- Expected:
-- payment_method = 'qris'
-- paid = total
-- change = 0
```

### Check Statistics
```sql
-- Count by payment method
SELECT 
    payment_method,
    COUNT(*) as total,
    SUM(total) as total_amount
FROM transactions
GROUP BY payment_method;
```

---

## ✅ Success Criteria

### QRIS Flow Working If:
1. ✅ QRIS button activates correctly
2. ✅ Cash input hides automatically
3. ✅ Process button enables without input
4. ✅ QR modal displays on "Bayar" click
5. ✅ QR image loads correctly
6. ✅ Transaction details populated
7. ✅ Confirm button processes payment
8. ✅ Success modal shows with correct data
9. ✅ Database saves payment_method = 'qris'
10. ✅ Change = 0 for all QRIS transactions

---

## 🎯 Performance Check

### Expected Timings:
- Modal open animation: **< 300ms**
- QR image load: **< 100ms** (local)
- Transaction processing: **< 1000ms**
- Success modal display: **< 200ms**
- Total user wait: **< 1.5s**

---

## 📝 Browser Console Check

### Should See:
```
🛒 Conventional Shop POS System Ready!
```

### Should NOT See:
- ❌ JavaScript errors
- ❌ 404 on QR image
- ❌ Undefined variable errors
- ❌ Function not found errors

---

## 🔄 Regression Testing

### Other Features Still Working:
- [ ] Add to cart
- [ ] Remove from cart
- [ ] Quantity update
- [ ] Search products
- [ ] Category filter
- [ ] Member selection
- [ ] Quick amount buttons
- [ ] Print receipt
- [ ] Clear cart
- [ ] Success modal close

---

## 📞 If Issues Found

1. **Clear cache first**:
   ```bash
   php artisan view:clear
   npm run build
   ```

2. **Check console** for JavaScript errors

3. **Verify files**:
   - `/images/payment/qris.jpg` exists
   - `resources/views/kasir/dashboard.blade.php` updated
   - Vite build completed

4. **Check documentation**:
   - `QRIS_PAYMENT_DOCUMENTATION.md`
   - `QRIS_IMPLEMENTATION_SUMMARY.md`

---

## 🎉 Happy Testing!

**Test URL**: http://127.0.0.1:8000/kasir

**Login as Kasir** to access POS dashboard and test QRIS payment flow.

---

**Created**: November 6, 2025  
**Version**: 1.0.0  
**Status**: Ready for Testing ✅
