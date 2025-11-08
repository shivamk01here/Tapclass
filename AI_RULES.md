# AI Assistant Rules for Htc Project

## Critical Rules - MUST FOLLOW

### 1. Database Changes
- ❌ **NEVER** use Laravel migrations
- ✅ **ALWAYS** write direct SQL queries in `.sql` files in project root
- ✅ Create SQL file with descriptive name (e.g., `add_column_name.sql`)
- ✅ Update `PROJECT_DOCS.md` with any schema changes

### 2. Documentation
- ✅ **ALWAYS** read `PROJECT_DOCS.md` first before making changes
- ✅ **ALWAYS** update `PROJECT_DOCS.md` after any:
  - Database schema changes
  - New routes added
  - New controller methods
  - New views created
  - Business logic changes
- ❌ **NEVER** create separate documentation files
- ❌ **NEVER** create summary files or temporary docs

### 3. Routes
- ✅ **ALWAYS** check `routes/web.php` for correct route names
- ✅ Use named routes in views (e.g., `route('tutors.search')`)
- ❌ **NEVER** hardcode URLs
- ✅ Common routes:
  - Public tutors: `tutors.search`, `tutors.profile`
  - Student: `student.dashboard`, `student.bookings`, etc.
  - Tutor: `tutor.dashboard`, `tutor.onboarding`, etc.

### 4. Code Style
- ✅ Use TailwindCSS utility classes (no custom CSS)
- ✅ Follow existing patterns in controllers
- ✅ Use Eloquent relationships defined in models
- ✅ Maintain consistent naming conventions
- ✅ Use Material Symbols icons

### 5. File Organization
- Controllers: `app/Http/Controllers/`
- Models: `app/Models/`
- Views: `resources/views/` (organized by role)
- Routes: `routes/web.php`
- SQL: `*.sql` in project root
- Documentation: `PROJECT_DOCS.md` ONLY

### 6. Data Handling
- ✅ Use JSON arrays for multiple selections (e.g., subjects_of_interest)
- ✅ Cast JSON fields in models: `protected $casts = ['field' => 'array']`
- ✅ Use DB transactions for multi-step operations
- ✅ Validate all user inputs

### 7. Authentication & Authorization
- ✅ Check user role before operations
- ✅ Use middleware: `auth`, `role:student`, `role:tutor`, `role:admin`
- ✅ Verify ownership before edit/delete operations

### 8. Common Patterns

**Fetching Related Data:**
```php
// Eager load relationships
Model::with(['relation1', 'relation2'])->get();
```

**Filtering with whereHas:**
```php
// Filter by relationship
TutorProfile::whereHas('subjects', function($q) use ($ids) {
    $q->whereIn('subject_id', $ids);
})->get();
```

**Wallet Operations:**
```php
// Always use increment/decrement
$wallet->increment('balance', $amount);
$wallet->decrement('balance', $amount);
```

### 9. View Conventions
- Extend proper layout: `@extends('layouts.student')`
- Use `@section('content')` for main content
- Display validation errors with `@error` directive
- Show success messages from session
- Use consistent card styling: `bg-white rounded-xl border`

### 10. Before Making Changes
1. Read `PROJECT_DOCS.md` completely
2. Check existing routes in `routes/web.php`
3. Review similar existing code
4. Understand the data flow
5. Make changes
6. Update `PROJECT_DOCS.md`
7. Test route names and relationships

---

## Project-Specific Notes

### Student Features
- Dashboard shows subject-based recommendations
- subjects_of_interest stored in student_profiles table (JSON)
- Can select subjects during registration or update in profile
- All tutor browsing uses public routes (not student-specific)

### Tutor Features
- Subjects and rates stored in tutor_subjects pivot table
- Each subject can have different online_rate and offline_rate
- Must be verified to appear in public search
- Verification status shown in onboarding

### Booking Features
- 4-step flow: Subject → Mode → Date/Time → Confirm
- Payment happens from student wallet
- Pricing is subject-specific (from tutor_subjects table)
- Status: pending → confirmed → completed/cancelled

### Database
- Uses MySQL
- All IDs are auto-increment integers
- Timestamps: created_at, updated_at (handled by Laravel)
- Soft deletes: NOT used
- Foreign keys: Defined but not enforced in code

---

## Checklist for AI Assistants

Before making changes:
- [ ] Read PROJECT_DOCS.md
- [ ] Check routes/web.php for route names
- [ ] Review existing similar code
- [ ] Understand relationships in models

After making changes:
- [ ] Test route names are correct
- [ ] Update PROJECT_DOCS.md with changes
- [ ] Verify relationships still work
- [ ] Check authentication is correct

---

## Common Mistakes to Avoid

❌ Using `route('tutors.index')` → ✅ Use `route('tutors.search')`
❌ Using `route('student.tutor-profile')` → ✅ Use `route('tutors.profile')`
❌ Creating migrations → ✅ Create SQL files
❌ Creating separate MD files → ✅ Update PROJECT_DOCS.md
❌ Hardcoding database values → ✅ Fetch from DB
❌ Missing eager loading → ✅ Use `with()` to prevent N+1

---

*Read this file completely before starting any work on the project*
*When in doubt, check PROJECT_DOCS.md first*
