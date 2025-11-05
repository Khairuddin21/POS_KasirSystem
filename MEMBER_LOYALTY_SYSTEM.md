# Member Loyalty & Rating System

## Overview
Member loyalty system with automatic points accumulation and tier-based star ratings based on total spending.

## Features Implemented

### 1. Points System
- **Calculation**: Every Rp 500,000 spent = +0.5 points
- **Accumulation**: Points are automatically added after each successful transaction
- **Storage**: Points stored as decimal(10,2) in database

### 2. Rating System (Star Tiers)
Members are automatically assigned a star rating based on their total lifetime spending:

| Rating | Total Spending Range | Display |
|--------|---------------------|---------|
| 1★ | Rp 0 - 999,999 | ★☆☆☆☆ |
| 2★ | Rp 1,000,000 - 1,999,999 | ★★☆☆☆ |
| 3★ | Rp 2,000,000 - 2,999,999 | ★★★☆☆ |
| 4★ | Rp 3,000,000 - 4,999,999 | ★★★★☆ |
| 5★ | Rp 5,000,000+ | ★★★★★ |

### 3. Database Schema
**Table**: `members`

**New Columns**:
- `total_spent` - DECIMAL(15,2) DEFAULT 0 - Total amount spent by member
- `rating` - TINYINT DEFAULT 1 - Star rating (1-5)

**Migration**: `database/migrations/2025_11_05_072457_add_total_spent_and_rating_to_members_table.php`

### 4. Model Methods

**File**: `app/Models/Member.php`

```php
// Calculate rating based on total_spent
public function calculateRating()

// Update member after purchase (add to total_spent, calculate points, update rating)
public function addPurchase($amount)

// Get rating as star string (accessor)
public function getRatingStarsAttribute()
```

### 5. Integration

**File**: `app/Http/Controllers/Kasir/KasirController.php`

The `processTransaction()` method now automatically updates member data:
```php
// After successful transaction
if ($request->member_id) {
    $member = Member::find($request->member_id);
    if ($member) {
        $member->addPurchase($total);
    }
}
```

### 6. UI Display

**File**: `resources/views/kasir/dashboard.blade.php`

**Member Search Results**:
- Shows member name, code, phone
- Displays current points (e.g., "15.5 poin")
- Shows rating stars (e.g., "★★★☆☆")

**Selected Member Display**:
- Shows member initial in colored badge
- Displays name and member code
- Shows current points
- **NEW**: Displays rating stars in yellow (★★★★★)

## How It Works

### Transaction Flow:
1. Kasir selects member from search
2. Member info displayed with current rating
3. Transaction processed with products
4. Payment completed
5. **Automatic Update**:
   - `total_spent` += transaction total
   - Points calculated: (total / 500,000) × 0.5
   - Rating recalculated based on new total_spent
   - Member data saved

### Example Calculation:
- **Transaction**: Rp 750,000
- **Points Added**: (750,000 / 500,000) × 0.5 = 0.75 points
- **If member total was**: Rp 1,800,000 (2★)
- **New total**: Rp 2,550,000
- **New rating**: 3★ (automatically updated)

## Testing

### Test Scenario 1: New Member (1★)
- Create transaction: Rp 500,000
- Expected: +0.5 points, rating stays 1★

### Test Scenario 2: Upgrade to 2★
- Member total: Rp 950,000 (1★)
- Create transaction: Rp 100,000
- Expected: Total = Rp 1,050,000, rating upgrades to 2★

### Test Scenario 3: High Value Transaction
- Member total: Rp 4,500,000 (4★)
- Create transaction: Rp 600,000
- Expected: Total = Rp 5,100,000, rating upgrades to 5★, +0.6 points

## API Response

**Endpoint**: `GET /kasir/member/search?q={query}`

**Response**:
```json
{
  "success": true,
  "members": [
    {
      "id": 1,
      "member_code": "MBR20250101",
      "name": "John Doe",
      "phone": "08123456789",
      "points": 15.5,
      "rating": 3,
      "total_spent": 2750000.00,
      "rating_stars": "★★★☆☆"
    }
  ]
}
```

## Files Modified

1. ✅ `app/Models/Member.php` - Added loyalty calculation methods
2. ✅ `app/Http/Controllers/Kasir/KasirController.php` - Added member update logic
3. ✅ `app/Http/Controllers/MemberController.php` - Updated search to include rating
4. ✅ `resources/views/kasir/dashboard.blade.php` - UI updates for rating display
5. ✅ `database/migrations/2025_11_05_072457_add_total_spent_and_rating_to_members_table.php` - Schema changes

## Status
✅ **COMPLETE** - All features implemented and tested
- Database migration executed successfully
- Model logic implemented
- Transaction integration complete
- UI updated with rating display
- Vite assets rebuilt
- Caches cleared

## Notes
- Points are stored with 2 decimal precision
- Rating updates automatically on each transaction
- Members start at 1★ rating by default
- System handles both cash and digital payment methods
- Rating is calculated server-side for data integrity
