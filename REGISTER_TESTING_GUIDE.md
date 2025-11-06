# 🧪 Register Testing Guide

## ⚡ Quick Testing Steps

### 1️⃣ **Akses Halaman Register**
```
URL: http://127.0.0.1:8000/register
```

### 2️⃣ **Test Validation Errors**

#### A. Empty Form Submit
1. Klik "Daftar Sekarang" tanpa isi apapun
2. **Expected**: Browser validation muncul

#### B. Invalid Email Format
1. Name: `Test User`
2. Email: `testemailcom` (no @)
3. Password: `password123`
4. Confirm: `password123`
5. ✓ Terms
6. Submit
7. **Expected**: Error "Format email tidak valid"

#### C. Short Password
1. Name: `Test User`
2. Email: `test@email.com`
3. Password: `123` (< 8 karakter)
4. Confirm: `123`
5. ✓ Terms
6. Submit
7. **Expected**: Error "Password minimal 8 karakter"

#### D. Password Mismatch
1. Name: `Test User`
2. Email: `test@email.com`
3. Password: `password123`
4. Confirm: `password456` (berbeda)
5. ✓ Terms
6. Submit
7. **Expected**: 
   - Red text "✗ Password tidak cocok"
   - Form tidak submit
   - Browser validation error

#### E. Terms Not Accepted
1. Isi semua field dengan benar
2. JANGAN centang "Terms & Conditions"
3. Submit
4. **Expected**: Alert "⚠️ Mohon setujui Syarat & Ketentuan untuk melanjutkan"

#### F. Email Already Exists
1. Name: `Test User`
2. Email: `admin@example.com` (sudah ada di database)
3. Password: `password123`
4. Confirm: `password123`
5. ✓ Terms
6. Submit
7. **Expected**: Error "Email sudah terdaftar"

---

### 3️⃣ **Test Successful Registration**

#### Data untuk Test:
```
Name: John Doe
Email: john.doe@example.com
Password: SecurePass123!
Confirm Password: SecurePass123!
✓ Terms & Conditions
```

#### Expected Flow:
1. Fill form dengan data di atas
2. Password strength indicator:
   - Muncul saat ketik password
   - Show "Kuat" (Green bar)
3. Password confirmation:
   - Ketik sama dengan password
   - Show "✓ Password cocok" (Green)
4. Click "Daftar Sekarang"
5. Button shows loading spinner
6. Redirect to: `http://127.0.0.1:8000/user/dashboard`
7. Success message muncul: "Selamat datang! Registrasi berhasil! 🎉"
8. User sudah login (lihat header/navbar)

---

### 4️⃣ **Verify Database**

#### Check User Created:
```sql
SELECT * FROM users 
WHERE email = 'john.doe@example.com';
```

#### Expected Result:
| id | name | email | role | password | created_at | updated_at |
|----|------|-------|------|----------|------------|------------|
| X | John Doe | john.doe@example.com | user | $2y$... (hashed) | 2025-11-06 ... | 2025-11-06 ... |

**Important Checks:**
- ✅ `role` = 'user' (NOT admin or kasir)
- ✅ `password` is hashed (starts with `$2y$`)
- ✅ `email` matches submitted data
- ✅ `name` matches submitted data
- ✅ `created_at` and `updated_at` populated

---

### 5️⃣ **Test Auto-Login**

After successful registration:
1. ✅ Redirected to user dashboard
2. ✅ User can see their name in header
3. ✅ User can access user menu items
4. ✅ Session created (check browser cookies)

Test logout and try login with registered credentials:
```
Email: john.doe@example.com
Password: SecurePass123!
```
Should login successfully!

---

## 🎨 Visual Tests

### Password Strength Indicator

#### Test 1: Weak Password
- Input: `abc123`
- Expected: 
  - Red bar (~40% width)
  - Text: "Lemah" (red color)

#### Test 2: Medium Password
- Input: `Password123`
- Expected:
  - Orange bar (~60% width)
  - Text: "Sedang" (orange color)

#### Test 3: Strong Password
- Input: `SecurePass123!@#`
- Expected:
  - Green bar (100% width)
  - Text: "Kuat" (green color)

### Password Match Indicator

#### Test 1: Matching
- Password: `password123`
- Confirm: `password123`
- Expected:
  - Green text "✓ Password cocok"

#### Test 2: Not Matching
- Password: `password123`
- Confirm: `password456`
- Expected:
  - Red text "✗ Password tidak cocok"

---

## 🔍 Browser Console Check

### Should See:
```
✅ Register Page Loaded! 📝
```

### Should NOT See:
- ❌ JavaScript errors
- ❌ 404 errors on assets
- ❌ CSRF token missing
- ❌ Form submit errors

---

## 📊 Testing Checklist

### Form Fields
- [ ] Name input: accepts text, shows error if empty
- [ ] Email input: validates format, checks uniqueness
- [ ] Password input: has eye icon toggle, shows strength
- [ ] Confirm password: shows match indicator
- [ ] Terms checkbox: must be checked

### Validation
- [ ] Empty fields: prevents submit
- [ ] Invalid email: shows error message (ID)
- [ ] Short password: shows error "minimal 8 karakter"
- [ ] Mismatch password: prevents submit with browser validation
- [ ] Duplicate email: shows error "sudah terdaftar"
- [ ] Unchecked terms: shows alert

### UI/UX
- [ ] Password strength bar: appears on input
- [ ] Password strength text: updates (Lemah/Sedang/Kuat)
- [ ] Password match text: shows ✓ or ✗
- [ ] Submit button: shows loading spinner
- [ ] Error messages: have red icon and red text
- [ ] Success message: green banner with icon

### Functionality
- [ ] Form submits to correct route (`/register` POST)
- [ ] User created in database with role='user'
- [ ] Password hashed correctly (bcrypt)
- [ ] Auto-login after registration
- [ ] Redirect to user dashboard
- [ ] Success message displayed
- [ ] Session created

### Database
- [ ] User record created
- [ ] Email unique constraint works
- [ ] Password is hashed (not plain text)
- [ ] Role defaults to 'user'
- [ ] Timestamps populated

---

## 🐛 Common Issues

### Issue 1: Form tidak submit
**Check:**
- Browser console for errors
- CSRF token in form
- Network tab for POST request
- Validation errors displayed

### Issue 2: Data tidak tersimpan
**Check:**
- Database connection
- Migration ran (`php artisan migrate:status`)
- Check `users` table exists
- Check validation passes

### Issue 3: Password tidak di-hash
**Check:**
- Using `Hash::make()` in controller
- Password column type is `varchar(255)`

### Issue 4: Auto-login tidak work
**Check:**
- Session driver configured (`.env`)
- `Auth::login($user)` called after create
- Session table exists (if using database driver)

### Issue 5: Redirect error
**Check:**
- Route `user.dashboard` exists
- User has access to user routes
- No middleware blocking

---

## ✅ Success Criteria

Registration is working if:
1. ✅ Form validation works (both frontend & backend)
2. ✅ User data saved to database
3. ✅ Password hashed with bcrypt
4. ✅ Role set to 'user'
5. ✅ Auto-login successful
6. ✅ Redirect to user dashboard
7. ✅ Success message displayed
8. ✅ Can logout and login again with same credentials

---

## 📝 Test Data Examples

### Valid Test Cases:

```
Test 1:
Name: Alice Johnson
Email: alice@example.com
Password: AlicePass123!
Role (auto): user

Test 2:
Name: Bob Smith
Email: bob.smith@example.com
Password: BobSecure456#
Role (auto): user

Test 3:
Name: Charlie Brown
Email: charlie.brown@example.com
Password: Charlie789$%
Role (auto): user
```

### Invalid Test Cases:

```
Test 1 (Empty):
Name: 
Email: 
Password: 
Expected: Browser validation

Test 2 (Invalid Email):
Name: Test User
Email: notanemail
Password: password123
Expected: "Format email tidak valid"

Test 3 (Short Password):
Name: Test User
Email: test@email.com
Password: abc
Expected: "Password minimal 8 karakter"

Test 4 (Duplicate Email):
Name: Test User
Email: admin@example.com (exists)
Password: password123
Expected: "Email sudah terdaftar"
```

---

## 🎯 Performance Check

Expected timings:
- Form load: < 500ms
- Password strength update: < 50ms (instant)
- Form submit: < 1500ms
- Database insert: < 200ms
- Auto-login: < 100ms
- Redirect: < 300ms
- **Total user wait: ~2 seconds**

---

## 📞 If Issues Found

1. **Clear all caches:**
   ```bash
   php artisan route:clear
   php artisan view:clear
   php artisan config:clear
   npm run build
   ```

2. **Check logs:**
   - Laravel log: `storage/logs/laravel.log`
   - Browser console
   - Network tab

3. **Verify files:**
   - Controller: `app/Http/Controllers/Auth/AuthController.php`
   - Routes: `routes/web.php`
   - View: `resources/views/auth/register.blade.php`

4. **Database:**
   ```bash
   php artisan migrate:status
   ```

---

**Test URL**: http://127.0.0.1:8000/register

**Happy Testing! 🎉**

---

**Created**: November 6, 2025  
**Version**: 1.0.0  
**Status**: Ready for Testing ✅
