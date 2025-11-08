# Admin Approval Workflow Guide

## How Tutor Approval Works

### 1. **Tutor Registration**
When a tutor registers, their profile is automatically set to `verification_status = 'pending'`

### 2. **Admin Dashboard**
- Log in as admin: `admin@Htc.com` / `admin123`
- Navigate to **Admin Dashboard** → **Tutors** tab
- You'll see pending tutors at the top

### 3. **Review Tutor**
Click "View" on any pending tutor to see:
- Personal information
- Education details
- Government ID (image)
- Degree certificate (image)
- CV (if uploaded)
- Subjects and rates
- Experience

### 4. **Approve or Reject**

#### **To Approve:**
1. Click the green "Approve" button
2. Status changes to `verified`
3. Tutor receives a notification
4. Tutor can now accept bookings
5. Tutor dashboard shows "Profile Verified"

#### **To Reject:**
1. Click the red "Reject" button
2. Enter a reason (minimum 10 characters)
3. Tutor receives rejection notification with reason
4. Tutor dashboard shows rejection message

### 5. **Tutor Dashboard States**

**Pending Approval:**
```
⏳ Your profile is under review
Please wait while our team verifies your credentials.
```

**Approved:**
```
✅ Profile Verified
You can now accept bookings!
```

**Rejected:**
```
❌ Profile Rejected
Reason: [Admin's reason here]
```

## Routes

- **Admin Login:** `/login` (use admin credentials)
- **Tutors List:** `/admin/tutors`
- **Verify Tutor:** `/admin/tutors/verify/{user_id}`
- **Approve:** POST `/admin/tutors/approve/{user_id}`
- **Reject:** POST `/admin/tutors/reject/{user_id}`

## Fix Applied

### Issue Fixed:
The `approveTutor` and `rejectTutor` methods were trying to find by profile ID instead of user ID.

### Solution:
Changed:
```php
$tutor = TutorProfile::findOrFail($id);
```

To:
```php
$tutor = TutorProfile::where('user_id', $id)->firstOrFail();
```

Now the approval system works correctly!

## Testing the Flow

1. **Register as a tutor** (not with Google - use regular form with all documents)
2. **Log out**
3. **Log in as admin** (`admin@Htc.com` / `admin123`)
4. **Go to Admin → Tutors**
5. **Click "View"** on the pending tutor
6. **Click "Approve"**
7. **Log out**
8. **Log in as the tutor**
9. **Check dashboard** - should show "Profile Verified" ✅

## Common Issues

### Problem: Rates showing ₹0
**Cause:** Tutor didn't set rates during registration or rates were set to 0

**Solution:** 
- Tutors must enter valid rates (> 0) for subjects
- If rates are 0 or NULL, it shows "Price on request"

### Problem: Can't approve from admin panel
**Cause:** Was using wrong ID (profile id instead of user_id)

**Solution:** Fixed in AdminController - now uses `user_id` correctly

## Database Schema

**tutor_profiles table:**
- `user_id` - Foreign key to users table
- `verification_status` - enum: 'pending', 'verified', 'rejected'
- `is_verified_badge` - boolean (true when approved)
- `verification_notes` - Admin notes for rejection

**Workflow:**
```
Registration → pending → Admin Review → verified/rejected
                                      ↓
                            Tutor can accept bookings
```
