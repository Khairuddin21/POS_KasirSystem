# 📱 QRIS Payment Gateway - Dokumentasi Lengkap

## 🎯 Overview
Sistem pembayaran QRIS (Quick Response Code Indonesian Standard) terintegrasi pada POS Kasir dengan flow yang simpel dan user-friendly.

---

## 🔄 Payment Flow

### **1. Pilih Metode Pembayaran**
- Kasir memilih antara **TUNAI** atau **QRIS**
- Default: TUNAI (Cash)
- Button layout: 2 large cards dengan icon dan label

### **2. QRIS Flow**
```
Pilih QRIS → Input Cash Hidden → Klik "Bayar (F4)" → QR Modal Muncul → 
Scan QR Code → Klik "Konfirmasi Pembayaran" → Process Transaction → Success Modal
```

### **3. Cash Flow**
```
Pilih TUNAI → Input Uang Dibayar → Hitung Kembalian → Klik "Bayar (F4)" → 
Process Transaction → Success Modal
```

---

## 🎨 UI Components

### **Payment Method Buttons**
- **Location**: `resources/views/kasir/dashboard.blade.php` (Line ~227)
- **Structure**: 
  ```html
  <div class="payment-methods grid grid-cols-2 gap-3 mb-3">
      <button class="payment-method-btn-large active" data-method="cash">
          💵 TUNAI
      </button>
      <button class="payment-method-btn-large" data-method="qris">
          📱 QRIS
      </button>
  </div>
  ```

### **Cash Input Section**
- **ID**: `#cashInputSection`
- **Visibility**: 
  - TUNAI: `display: block` ✅
  - QRIS: `display: none` ❌
- **Contains**:
  - Input uang dibayar
  - Display kembalian

### **QRIS Modal**
- **ID**: `#qrisModal`
- **Location**: After success modal (~Line 1430)
- **Components**:
  - Header (Blue gradient)
  - QR Code Image (`/images/payment/qris.jpg`)
  - Transaction Details (Total, Code, Date)
  - Payment Instructions (5 steps)
  - Action Buttons (Batal, Konfirmasi)

---

## 💻 JavaScript Functions

### **selectPaymentMethod(method)**
- **Purpose**: Handle payment method switching
- **Location**: ~Line 2343
- **Logic**:
  ```javascript
  if (method === 'qris') {
      // Hide cash input section
      cashInputSection.style.display = 'none';
      
      // Auto-set paid = total
      document.getElementById('paidAmount').value = total;
      
      // Enable process button (no need manual input)
      if (cart.length > 0) {
          processBtn.disabled = false;
      }
      
      // Show notification
      showNotification('💳 Pilih QRIS - Langsung klik Bayar untuk scan QR', 'info');
  } else {
      // Show cash input section
      cashInputSection.style.display = 'block';
      // ... calculate change
  }
  ```

### **showQrisModal()**
- **Purpose**: Display QR code modal with transaction details
- **Location**: ~Line 2378
- **Data Populated**:
  - Total: `Rp X.XXX`
  - Transaction Code: `TRX-{timestamp}`
  - Date: Current datetime (id-ID locale)

### **closeQrisModal()**
- **Purpose**: Close QR modal
- **Location**: ~Line 2392

### **confirmQrisPayment()**
- **Purpose**: Confirm payment and process transaction
- **Location**: ~Line 2397
- **Flow**:
  ```javascript
  closeQrisModal();
  processTransaction(true); // Pass true flag
  ```

### **processTransaction(fromQris)**
- **Purpose**: Process transaction (Cash or QRIS)
- **Location**: ~Line 2210
- **Enhanced Logic**:
  ```javascript
  // QRIS Flow
  if (selectedPaymentMethod === 'qris') {
      if (!arguments[0]) {
          // Show QR modal first
          showQrisModal();
          return;
      }
      // Auto-set paid = total
      document.getElementById('paidAmount').value = total;
  }
  
  // Validation
  if (selectedPaymentMethod === 'cash' && paid < total) {
      showNotification('❌ Pembayaran tidak mencukupi!', 'error');
      return;
  }
  
  // Send to server with payment_method
  data = {
      items: [...],
      payment_method: selectedPaymentMethod, // 'cash' or 'qris'
      paid: paid,
      change: selectedPaymentMethod === 'qris' ? 0 : (paid - total)
  }
  ```

---

## 🎨 CSS Styling

### **Large Payment Buttons**
```css
.payment-method-btn-large {
    padding: 20px;
    border: 2px solid #e5e7eb;
    border-radius: 16px;
    background: white;
    min-height: 120px;
    transition: all 0.3s ease;
}

.payment-method-btn-large:hover {
    border-color: #3b82f6;
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    transform: translateY(-2px);
}

.payment-method-btn-large.active {
    border-color: #3b82f6;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    box-shadow: 0 4px 16px rgba(59, 130, 246, 0.4);
}

.payment-method-btn-large.active * {
    color: white !important;
}
```

### **Notification Types**
```css
.notification-toast.success { /* Green gradient */ }
.notification-toast.error { /* Red gradient */ }
.notification-toast.info { /* Blue gradient */ }
.notification-toast.warning { /* Orange gradient */ }
```

---

## 🗄️ Backend Integration

### **Controller: KasirController**
- **File**: `app/Http/Controllers/Kasir/KasirController.php`
- **Method**: `processTransaction(Request $request)`
- **Validation**:
  ```php
  $request->validate([
      'items' => 'required|array',
      'payment_method' => 'required|in:cash,card,qris,transfer',
      'paid' => 'required|numeric|min:0',
      // ...
  ]);
  ```

### **Database: transactions table**
- **Column**: `payment_method`
- **Type**: `ENUM('cash', 'card', 'qris', 'transfer')`
- **Default**: `'cash'`
- **Migration**: `2025_10_24_024926_create_transactions_table.php`

### **Response Structure**
```json
{
    "success": true,
    "message": "Transaksi berhasil!",
    "transaction": {
        "id": 123,
        "transaction_code": "TRX-20251106-0001",
        "payment_method": "qris",
        "total": 150000,
        "paid": 150000,
        "change": 0,
        // ...
    }
}
```

---

## 🎯 User Experience

### **QRIS Advantages**
1. ✅ **No Manual Input** - Tidak perlu input uang dibayar
2. ✅ **Exact Amount** - Pembayaran pas (no change)
3. ✅ **Fast Processing** - Langsung klik Bayar → Scan QR
4. ✅ **Clear Instructions** - Step-by-step guide dalam modal
5. ✅ **Visual Feedback** - Notification dan active states

### **Payment Method Comparison**

| Feature | TUNAI | QRIS |
|---------|-------|------|
| Input Cash | ✅ Required | ❌ Auto |
| Change Calculation | ✅ Yes | ❌ No (Exact) |
| Manual Confirmation | ❌ No | ✅ Yes (QR Modal) |
| Process Speed | Fast | Fast |
| Customer Receipt | ✅ Print | ✅ Digital + Print |

---

## 🔧 Technical Details

### **Global Variables**
```javascript
let selectedPaymentMethod = 'cash'; // Default payment method
```

### **Modal States**
- **Show**: `modal.classList.add('show')`
- **Hide**: `modal.classList.remove('show')`
- **CSS**: `.modal-overlay.show { display: flex; }`

### **Button States**
```javascript
// Enable
processBtn.disabled = false;
processBtn.classList.remove('opacity-50', 'cursor-not-allowed');

// Disable
processBtn.disabled = true;
processBtn.classList.add('opacity-50', 'cursor-not-allowed');
```

---

## 📋 Testing Checklist

### **QRIS Flow Testing**
- [ ] Pilih QRIS → Cash input hidden
- [ ] Button "Bayar" enabled saat ada item di cart
- [ ] Klik "Bayar" → QR modal muncul dengan smooth animation
- [ ] QR Code image tampil (`/images/payment/qris.jpg`)
- [ ] Transaction details populated (total, code, date)
- [ ] Klik "Batal" → Modal tertutup
- [ ] Klik "Konfirmasi Pembayaran" → Transaction processed
- [ ] Success modal muncul dengan data benar
- [ ] Payment method tersimpan sebagai "qris" di database
- [ ] Change = 0 untuk QRIS transactions

### **Cash Flow Testing**
- [ ] Pilih TUNAI → Cash input visible
- [ ] Input uang → Kembalian calculated correctly
- [ ] Button "Bayar" disabled jika paid < total
- [ ] Transaction processed dengan change correct
- [ ] Payment method tersimpan sebagai "cash"

### **Switch Testing**
- [ ] Switch TUNAI → QRIS: Input hidden, button enabled
- [ ] Switch QRIS → TUNAI: Input shown, button disabled until valid input
- [ ] Active state styling applied correctly
- [ ] Text color white pada active button

---

## 🚀 Performance

### **Optimizations**
1. **CSS Transitions**: 0.3s smooth animations
2. **Modal Animations**: `dashModalFade` & `dashModalZoom`
3. **Backdrop Blur**: 8px for modal overlay
4. **Lazy Display**: QR modal only shown when needed
5. **Sound Effects**: `playSound('click')` on modal open

### **Asset Loading**
- QR Image: Pre-loaded (`/images/payment/qris.jpg`)
- Vite Build: Compiled CSS & JS
- File Sizes:
  - CSS: ~54.65 KB (gzipped: 9.14 KB)
  - JS: ~41.46 KB (gzipped: 16.26 KB)

---

## 🔐 Security

### **Validation**
1. **Frontend**: 
   - Cart not empty check
   - Payment amount validation (cash only)
   - Payment method selection required

2. **Backend**:
   - CSRF Token validation
   - Enum validation for payment_method
   - Stock availability check
   - Transaction atomicity (DB::beginTransaction)

---

## 📱 QR Code Instructions

### **E-Wallet Support**
- GoPay ✅
- OVO ✅
- Dana ✅
- ShopeePay ✅
- LinkAja ✅
- Bank Apps (BCA, Mandiri, BRI, etc.) ✅

### **Steps Displayed**
1. Buka aplikasi e-wallet
2. Pilih menu Scan QR
3. Scan QR Code di modal
4. Konfirmasi pembayaran di app
5. Klik "Konfirmasi Pembayaran" di POS

---

## 🐛 Troubleshooting

### **QR Modal Not Showing**
- Check: `#qrisModal` element exists
- Check: `.modal-overlay.show` CSS applied
- Check: `showQrisModal()` function called
- Console: Check for JavaScript errors

### **Cash Input Not Hiding**
- Check: `#cashInputSection` wrapper exists
- Check: `selectPaymentMethod('qris')` called correctly
- Check: `cashInputSection.style.display = 'none'` executed

### **Button Not Enabling for QRIS**
- Check: Cart has items (`cart.length > 0`)
- Check: `processBtn.disabled = false` executed
- Check: Opacity classes removed

### **Payment Method Not Saved**
- Check: `selectedPaymentMethod` variable value
- Check: Backend validation passes
- Check: Database enum includes 'qris'
- Check: Response JSON has correct payment_method

---

## 📊 Statistics & Reporting

### **Payment Method Tracking**
```php
$statistics = [
    'cashTransactions' => Transaction::where('payment_method', 'cash')->count(),
    'qrisTransactions' => Transaction::where('payment_method', 'qris')->count(),
];
```

### **Export Support**
- CSV Export: ✅ Payment method included
- PDF Export: ✅ Payment method displayed
- Daily Report: ✅ Payment method statistics

---

## 🎓 Best Practices

1. **Always validate cart before showing modal**
2. **Use proper payment_method enum values**
3. **Auto-set paid = total for QRIS (no change)**
4. **Show clear notifications for user feedback**
5. **Test both payment flows thoroughly**
6. **Ensure QR image exists at correct path**
7. **Handle modal close events properly**
8. **Update statistics for both payment types**

---

## 📝 Changelog

### Version 1.0 (November 6, 2025)
- ✅ Initial QRIS payment implementation
- ✅ 2-button payment method layout
- ✅ QR code modal with confirmation flow
- ✅ Auto-hide cash input for QRIS
- ✅ Backend integration with validation
- ✅ Notification system improvements
- ✅ CSS styling enhancements
- ✅ Database support for QRIS
- ✅ Export functionality with payment method

---

## 🎯 Future Enhancements

- [ ] Real-time QRIS payment verification (webhook integration)
- [ ] Multiple QR code providers (GoPay, OVO, Dana individual QR)
- [ ] Transaction timeout for QRIS (auto-cancel after 5 minutes)
- [ ] QR code generation based on amount (dynamic QR)
- [ ] Payment confirmation SMS/Email
- [ ] QRIS transaction history filtering
- [ ] Refund support for QRIS payments

---

**Created**: November 6, 2025  
**Last Updated**: November 6, 2025  
**Maintained by**: POS Kasir Development Team
