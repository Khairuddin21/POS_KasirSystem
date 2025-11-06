# Admin Settings - Profile Management Documentation

## Overview
Halaman **Admin Settings** (`/admin/settings`) adalah fitur untuk mengelola profil dan keamanan akun admin yang sedang login.

## URL
- **Main Page**: `http://127.0.0.1:8000/admin/settings`

## Fitur Utama

### 1. Profile Information
Menampilkan dan mengedit informasi profil admin:
- **Full Name**: Nama lengkap admin
- **Email Address**: Email admin (unique validation)
- **Account Information**: Role dan tanggal registrasi (read-only)

### 2. Change Password
Mengubah password akun admin dengan validasi keamanan:
- **Current Password**: Password saat ini (wajib diverifikasi)
- **New Password**: Password baru (minimal 8 karakter)
- **Confirm New Password**: Konfirmasi password baru

## Teknologi & Styling

### CSS & Animations
1. **Gradient Backgrounds**:
   - Profile header: `from-cyan-500 to-blue-600`
   - Profile button: `from-cyan-500 to-blue-600`
   - Password button: `from-purple-500 to-pink-600`

2. **Custom Animations**:
   - `fadeIn`: Fade in dengan translateY (300ms)
   - `slideIn`: Slide in dari kiri (300ms)
   - `spinner`: Loading animation untuk buttons

3. **Interactive Elements**:
   - Input focus animation (translateY + shadow)
   - Button hover animation (translateY)
   - Tab navigation dengan active state
   - Password toggle visibility
   - Loading state pada submit buttons

### JavaScript Features
1. **Tab Navigation**:
   - `showTab(tabName)`: Switch antara Profile dan Password tabs
   - Dynamic active state dengan CSS classes

2. **Form Handling**:
   - **Profile Form**: Fetch API dengan JSON response
   - **Password Form**: Fetch API dengan validasi password
   - Error handling per field
   - SweetAlert2 untuk notifikasi

3. **Utility Functions**:
   - `togglePassword(inputId)`: Toggle password visibility
   - `resetProfileForm()`: Reset profile form
   - `resetPasswordForm()`: Reset password form
   - `hideAllErrors()`: Hide semua error messages
   - `showError(field, message)`: Show error per field

## Backend Implementation

### Controller: `SettingsController`
**Path**: `app/Http/Controllers/Admin/SettingsController.php`

#### Methods:
1. **index()**
   - Menampilkan halaman settings
   - Return: `admin.settings` view dengan user data

2. **updateProfile(Request $request)**
   - Update nama dan email admin
   - Validasi:
     - `name`: required, string, max 255
     - `email`: required, email, unique (exclude current user)
   - Return: JSON response dengan success/error

3. **updatePassword(Request $request)**
   - Update password admin
   - Validasi:
     - `current_password`: required, verified dengan Hash::check
     - `new_password`: required, min 8, confirmed
   - Return: JSON response dengan success/error

### Routes
**File**: `routes/web.php`

```php
// Settings Routes (dalam admin middleware group)
Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings');
Route::post('/settings/profile', [SettingsController::class, 'updateProfile'])->name('admin.settings.update.profile');
Route::post('/settings/password', [SettingsController::class, 'updatePassword'])->name('admin.settings.update.password');
```

## UI Components

### 1. Sidebar Navigation
- **Avatar Circle**: Initial 2 huruf dari nama (uppercase)
- **User Info**: Nama dan role
- **Tab Buttons**:
  - Profile Information (icon: user)
  - Change Password (icon: lock)

### 2. Profile Tab
- **Header**: Title dengan gradient icon
- **Form Fields**:
  - Name input dengan SVG icon
  - Email input dengan SVG icon
  - Account info box (read-only)
- **Actions**:
  - Reset button (gray)
  - Save Changes button (cyan-blue gradient)

### 3. Password Tab
- **Header**: Title dengan gradient icon (purple-pink)
- **Form Fields**:
  - Current password dengan toggle visibility
  - New password dengan toggle visibility
  - Confirm password dengan toggle visibility
- **Security Tips Box**: Amber warning dengan tips keamanan
- **Actions**:
  - Reset button (gray)
  - Update Password button (purple-pink gradient)

## Security Features

### 1. Validation
- **Email uniqueness**: Mencegah duplikasi email
- **Password verification**: Current password harus benar
- **Password confirmation**: New password harus match
- **Minimum length**: Password minimal 8 karakter

### 2. CSRF Protection
- Semua form menggunakan `@csrf` token
- Fetch requests menyertakan `X-CSRF-TOKEN` header

### 3. Password Hashing
- Password di-hash menggunakan `Hash::make()`
- Verification menggunakan `Hash::check()`

## Error Handling

### Frontend
- Error per field ditampilkan di bawah input
- SweetAlert2 untuk general errors
- Loading state mencegah double submit

### Backend
- Validation errors (422 status)
- JSON response dengan error details
- Generic error handling

## Notification System
**Library**: SweetAlert2 v11

### Success Notification
```javascript
Swal.fire({
    icon: 'success',
    title: 'Success!',
    text: data.message,
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true
});
```

### Error Notification
```javascript
Swal.fire({
    icon: 'error',
    title: 'Error!',
    text: data.message
});
```

## Responsive Design
- **Mobile**: Single column layout
- **Desktop**: Sidebar (1/3) + Content (2/3) layout
- Sticky sidebar pada desktop
- Touch-friendly button sizes

## Browser Compatibility
- Modern browsers (Chrome, Firefox, Safari, Edge)
- ES6+ JavaScript features
- CSS Grid & Flexbox
- CSS Custom Properties

## Testing

### Manual Testing Checklist
1. ✅ Load settings page
2. ✅ Tab navigation works
3. ✅ Profile form validation
4. ✅ Email uniqueness check
5. ✅ Password form validation
6. ✅ Current password verification
7. ✅ Password confirmation match
8. ✅ Success notifications
9. ✅ Error handling
10. ✅ Responsive layout

## Future Enhancements
- [ ] Avatar upload functionality
- [ ] Two-factor authentication
- [ ] Activity log/audit trail
- [ ] Email verification for email changes
- [ ] Password strength indicator
- [ ] Session management (logout other devices)

## Files Modified/Created

### Created
1. `app/Http/Controllers/Admin/SettingsController.php` (96 lines)
2. `resources/views/admin/settings.blade.php` (470 lines)
3. `ADMIN_SETTINGS_DOCUMENTATION.md` (dokumentasi ini)

### Modified
1. `routes/web.php` (added 3 settings routes)
2. `app/Models/User.php` (added $table property)

## Maintenance Notes
- Clear cache setelah update routes: `php artisan optimize:clear`
- Pastikan user authenticated sebelum akses settings
- Backup database sebelum update password logic
- Monitor error logs untuk failed login attempts

---
**Version**: 1.0.0  
**Created**: November 6, 2025  
**Last Updated**: November 6, 2025  
**Author**: AI Assistant  
**Status**: ✅ Production Ready
