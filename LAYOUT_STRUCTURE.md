# 📐 Landing Page Structure

## Visual Layout Overview

```
┌─────────────────────────────────────────────────────────┐
│                      NAVBAR (Sticky)                     │
│  Logo  [Fitur] [Solusi] [Keunggulan] [Harga] [Kontak]  │
│                              [Login] [Coba Gratis]       │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                 HERO SECTION (Gradient)                  │
│                                                           │
│  Nikmati Kemudahan Transaksi dengan                     │
│  Fitur Lengkap yang Praktis dan                         │
│  Mudah Digunakan                                         │
│                                                           │
│  [Mulai Sekarang] [Lihat Demo]        [Image-4.png]    │
│                                                           │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                    FITUR SECTION                         │
│                                                           │
│  ┌──────────┐  ┌──────────┐  ┌──────────┐              │
│  │  Icon 1  │  │  Icon 2  │  │  Icon 3  │              │
│  │ Transaksi│  │Notifikasi│  │Pencatatan│              │
│  │ Efisien  │  │ Digital  │  │  Akurat  │              │
│  └──────────┘  └──────────┘  └──────────┘              │
│                                                           │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│              PAYMENT OPTIONS SECTION                     │
│                                                           │
│  [Aset_Fitur_AplikasiKasir_ContentBlock2.png]          │
│                                                           │
│  Ragam Opsi Pembayaran untuk                            │
│  Kenyamanan Bertransaksi                                │
│                                                           │
│  ✓ Pisahkan Tagihan                                     │
│  ✓ Metode Pembayaran Lengkap                            │
│  ✓ Cicilan Mudah                                        │
│                                                           │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│              SOLUSI SECTION (Header Only)                │
│                                                           │
│       Solusi untuk Semua Kebutuhan                      │
│       Akses khusus untuk setiap role                    │
│       dalam bisnis Anda                                 │
│                                                           │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│         CASHIER MANAGEMENT SECTION (NEW!)               │
│                                                           │
│  Kelola Kasir dengan                    [cashier.png]   │
│  Lebih Mudah dan Efisien                                │
│                                                           │
│  ⚡ Proses Transaksi Cepat                              │
│  🧮 Perhitungan Otomatis                                │
│  💳 Multi Payment Method                                │
│                                                           │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│           LAPORAN & ANALYTICS SECTION (NEW!)            │
│                                                           │
│  [cashier2.png]              Laporan Lengkap untuk      │
│                              Keputusan Bisnis Tepat     │
│                                                           │
│                              📊 Laporan Real-time       │
│                              💰 Analisis Penjualan      │
│                              📄 Export Data             │
│                                                           │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                   CTA SECTION (Gradient)                 │
│                                                           │
│          Siap Meningkatkan Bisnis Anda?                 │
│          Bergabung dengan ribuan bisnis                 │
│                                                           │
│          [Daftar Sekarang] [Jadwalkan Demo]            │
│                                                           │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│              CONTACT SECTION (NEW!)                      │
│                                                           │
│                 Hubungi Kami                            │
│    Kami siap membantu Anda mengembangkan bisnis        │
│                                                           │
│  ┌─────────────┐ ┌─────────────┐ ┌─────────────┐      │
│  │   📱 Icon   │ │   📍 Icon   │ │   📧 Icon   │      │
│  │   Telepon   │ │   Alamat    │ │    Email    │      │
│  │             │ │             │ │             │      │
│  │ +62 813..   │ │ JL. Haji    │ │ bismilah... │      │
│  │             │ │ Mugeni III  │ │             │      │
│  │[WhatsApp]🟢│ │             │ │             │      │
│  └─────────────┘ └─────────────┘ └─────────────┘      │
│                                                           │
└─────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────┐
│                    FOOTER (Dark)                         │
│                                                           │
│  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐  │
│  │  Brand   │ │  Produk  │ │Perusahaan│ │Contact Us│  │
│  │          │ │          │ │          │ │          │  │
│  │ poskasir │ │ • Fitur  │ │• Tentang │ │📍 Address│  │
│  │          │ │ • Solusi │ │• Blog    │ │📱 Phone  │  │
│  │ Social:  │ │ • Harga  │ │• Karir   │ │📧 Email  │  │
│  │ [f][i][t]│ │          │ │          │ │          │  │
│  └──────────┘ └──────────┘ └──────────┘ └──────────┘  │
│                                                           │
│            © 2024 POS Kasir. All rights reserved        │
│                                                           │
└─────────────────────────────────────────────────────────┘
```

## Section Details

### 1. Navbar (Fixed Top)
- **Height**: ~80px
- **Background**: White (transparent → solid on scroll)
- **Contains**: Logo, Navigation Links, Login/Register buttons
- **Scroll Effect**: Shadow + backdrop blur

### 2. Hero Section
- **Background**: Cyan gradient (from-cyan-400 via-cyan-500 to-cyan-600)
- **Layout**: 50/50 text/image split
- **Image**: Image-4.png (floating animation)
- **CTAs**: 2 buttons (primary + secondary)

### 3. Features Section
- **Layout**: 3-column grid
- **Cards**: White background, shadow on hover
- **Icons**: Cyan background, 64x64px
- **Animation**: Fade in on scroll

### 4. Payment Section
- **Layout**: Image left, content right
- **Background**: Light gradient (cyan-50 to blue-50)
- **Image**: Aset_Fitur_AplikasiKasir_ContentBlock2.png
- **Features**: 3 items with icons

### 5. Solusi Section
- **Layout**: Centered heading + subtitle
- **Purpose**: Section divider
- **Background**: White

### 6. Cashier Management (NEW!)
- **Layout**: Content left, image right
- **Image**: cashier.png (rounded corners)
- **Background**: White
- **Features**: 3 items with cyan icons

### 7. Laporan & Analytics (NEW!)
- **Layout**: Image left, content right (alternating)
- **Image**: cashier2.png (rounded corners)
- **Background**: White
- **Features**: 3 items with cyan icons

### 8. CTA Section
- **Background**: Cyan to blue gradient
- **Layout**: Centered content
- **CTAs**: 2 buttons (white + outline)

### 9. Contact Section (NEW!)
- **Layout**: 3-column grid
- **Cards**: White with hover effects
- **Icons**: Cyan circles with bounce animation
- **Special**: WhatsApp button with pulse animation
- **Background**: Gray-50

### 10. Footer
- **Layout**: 4-column grid
- **Background**: Dark gray (gray-900)
- **Contains**: 
  - Column 1: Brand + social media
  - Column 2: Product links
  - Column 3: Company links
  - Column 4: Contact info

## Responsive Breakpoints

### Mobile (< 768px)
- Single column layout
- Stacked sections
- Mobile menu (hamburger)
- Reduced font sizes

### Tablet (768px - 1024px)
- 2-column grid where applicable
- Optimized spacing
- Larger touch targets

### Desktop (> 1024px)
- Full multi-column layouts
- Maximum 1280px container width
- Larger images and spacing

## Color Zones

```
Cyan Gradient  : Hero, CTA
White          : Features, Cashier sections
Light Gradient : Payment section
Light Gray     : Contact section
Dark Gray      : Footer
```

## Animation Zones

```
Scroll Effects : Navbar, Section reveals
Hover Effects  : All cards, buttons, links
Click Effects  : Buttons (ripple)
Floating       : Hero image
Pulse          : WhatsApp button
Bounce         : Contact icons
```

---

**Last Updated**: October 23, 2025
