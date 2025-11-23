# School Management System - Testing & Validation Guide

This document helps you verify that the School Management System is correctly set up and functioning without errors.

## Quick Validation Checklist

### ✅ 1. PHP Syntax Validation

Run this command to check all PHP files for syntax errors:

```bash
# Check all models
php -l app/Models/*.php

# Check all migrations
php -l database/migrations/*.php
```

**Expected Result**: `No syntax errors detected` for all files

---

### ✅ 2. Autoload Verification

Regenerate the autoload files and verify packages are discovered:

```bash
composer dump-autoload
```

**Expected Result**:
- "Generated optimized autoload files containing XXXX classes"
- Package manifest generated successfully

---

### ✅ 3. Clear All Caches

Clear Laravel's caches to ensure fresh state:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

**Expected Result**: All caches cleared successfully

---

### ✅ 4. Migration Order Verification

The migrations MUST run in this specific order to avoid foreign key errors:

```bash
ls -1 database/migrations/2025_11_23_*.php
```

**Expected Order**:
1. `2025_11_23_115047_add_role_to_users_table.php`
2. `2025_11_23_115055_create_classes_table.php` ← Created BEFORE student references
3. `2025_11_23_115102_create_sections_table.php` ← Created BEFORE student references
4. `2025_11_23_115109_create_subjects_table.php`
5. `2025_11_23_115149_create_student_attendances_table.php`
6. `2025_11_23_115156_create_teacher_attendances_table.php`
7. `2025_11_23_115200_enhance_students_table.php` ← NOW references classes/sections
8. `2025_11_23_115209_create_exams_table.php`
9. `2025_11_23_115210_enhance_teachers_table.php`
10. `2025_11_23_115216_create_exam_results_table.php`
11. `2025_11_23_115220_create_class_subject_table.php`
12. `2025_11_23_115224_create_fees_table.php`
13. `2025_11_23_115230_create_teacher_subject_table.php`
14. `2025_11_23_115231_create_fee_payments_table.php`
15. `2025_11_23_115238_create_timetables_table.php`
16. `2025_11_23_115249_create_assignments_table.php`
17. `2025_11_23_115256_create_announcements_table.php`
18. `2025_11_23_115304_create_parents_table.php`
19. `2025_11_23_115311_create_student_parent_table.php`

---

### ✅ 5. Database Configuration

1. **Copy Environment File** (if not already done):
```bash
cp .env.example .env
```

2. **Generate Application Key** (if not already done):
```bash
php artisan key:generate
```

3. **Configure Database** in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

4. **Create Database**:
```bash
# Login to MySQL
mysql -u root -p

# Create database
CREATE DATABASE school_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

---

### ✅ 6. Run Migrations

**IMPORTANT**: This is the critical test. If migrations fail, there's a dependency error.

```bash
php artisan migrate
```

**Expected Result**: All migrations run successfully without errors

**Common Errors & Solutions**:

❌ **Error**: `SQLSTATE[HY000] [2002] Connection refused`
✅ **Solution**: Start MySQL/MariaDB service
```bash
# Ubuntu/Debian
sudo service mysql start

# macOS (Homebrew)
brew services start mysql

# Windows (XAMPP)
Start MySQL from XAMPP Control Panel
```

❌ **Error**: `Base table or view not found: 1146 Table 'xxx' doesn't exist`
✅ **Solution**: Migration order is wrong. Verify step 4 above.

❌ **Error**: `SQLSTATE[42S21]: Column already exists`
✅ **Solution**: Database has old migrations. Fresh migrate:
```bash
php artisan migrate:fresh
```

---

### ✅ 7. Verify Database Tables

After successful migration, verify all tables exist:

```bash
php artisan migrate:status
```

**Expected Result**: All migrations should show "Ran"

Or check directly in MySQL:
```bash
mysql -u root -p school_management -e "SHOW TABLES;"
```

**Expected Tables** (25 total):
```
announcements
assignments
class_subject
classes
employees
exam_results
exams
failed_jobs
fee_payments
fees
migrations
parents
password_resets
sections
student_attendances
student_parent
students
subjects
teacher_attendances
teacher_subject
teachers
timetables
users
```

---

### ✅ 8. Model Verification

Test that all models can be loaded without errors:

```bash
php artisan tinker
```

Then run in tinker:
```php
// Test each model loads correctly
App\Models\User::first(); // May be null, but shouldn't error
App\Models\Student::first();
App\Models\Teacher::first();
App\Models\SchoolClass::first();
App\Models\Section::first();
App\Models\Subject::first();
App\Models\StudentAttendance::first();
App\Models\TeacherAttendance::first();
App\Models\Exam::first();
App\Models\ExamResult::first();
App\Models\Fee::first();
App\Models\FeePayment::first();
App\Models\Timetable::first();
App\Models\Assignment::first();
App\Models\Announcement::first();
App\Models\ParentModel::first();

// Test relationships are defined
$user = new App\Models\User;
get_class_methods($user); // Should include relationship methods

exit
```

**Expected Result**: No errors, models load successfully

---

### ✅ 9. Create Test Data

Create a complete test record to verify all relationships work:

```bash
php artisan tinker
```

```php
// 1. Create Admin User
$admin = \App\Models\User::create([
    'name' => 'System Admin',
    'email' => 'admin@school.test',
    'password' => bcrypt('admin123'),
    'role' => 'admin',
    'is_active' => true
]);

// 2. Create a Class
$class = \App\Models\SchoolClass::create([
    'name' => 'Class 10',
    'numeric_name' => '10',
    'is_active' => true
]);

// 3. Create a Subject
$subject = \App\Models\Subject::create([
    'name' => 'Mathematics',
    'code' => 'MATH10',
    'total_marks' => 100,
    'passing_marks' => 40,
    'is_active' => true
]);

// 4. Link Subject to Class
$class->subjects()->attach($subject->id);

// 5. Create Teacher User
$teacherUser = \App\Models\User::create([
    'name' => 'John Smith',
    'email' => 'teacher@school.test',
    'password' => bcrypt('teacher123'),
    'role' => 'teacher',
    'is_active' => true
]);

// 6. Create Teacher Profile
$teacher = \App\Models\Teacher::create([
    'user_id' => $teacherUser->id,
    'employee_id' => 'EMP001',
    'firstname' => 'John',
    'lastname' => 'Smith',
    'email' => 'teacher@school.test',
    'phone' => '1234567890',
    'status' => 'active'
]);

// 7. Create Section
$section = \App\Models\Section::create([
    'class_id' => $class->id,
    'name' => 'A',
    'capacity' => 30,
    'class_teacher_id' => $teacher->id,
    'is_active' => true
]);

// 8. Create Student User
$studentUser = \App\Models\User::create([
    'name' => 'Alice Johnson',
    'email' => 'student@school.test',
    'password' => bcrypt('student123'),
    'role' => 'student',
    'is_active' => true
]);

// 9. Create Student Profile
$student = \App\Models\Student::create([
    'user_id' => $studentUser->id,
    'class_id' => $class->id,
    'section_id' => $section->id,
    'name' => 'Alice Johnson',
    'admission_number' => 'ADM2024001',
    'roll_number' => '1',
    'status' => 'active'
]);

// 10. Verify Relationships Work
echo "Student Class: " . $student->class->name . "\n";
echo "Student Section: " . $student->section->name . "\n";
echo "Section Teacher: " . $section->classTeacher->full_name . "\n";
echo "Class Subjects: " . $class->subjects->count() . "\n";

exit
```

**Expected Result**:
- All records created successfully
- All relationships return correct data
- No errors during creation or retrieval

---

### ✅ 10. Foreign Key Constraint Verification

Test that foreign key constraints work correctly:

```bash
php artisan tinker
```

```php
// Test cascade delete works
$class = \App\Models\SchoolClass::first();
$classId = $class->id;

// Create a section for this class
$section = \App\Models\Section::create([
    'class_id' => $classId,
    'name' => 'TestSection',
    'is_active' => true
]);

echo "Section created with ID: " . $section->id . "\n";

// Delete the class - section should also be deleted (cascade)
$class->delete();

// Verify section was deleted
$deletedSection = \App\Models\Section::find($section->id);
echo "Section after class deletion: " . ($deletedSection ? 'Still exists (ERROR!)' : 'Deleted (CORRECT!)') . "\n";

exit
```

**Expected Result**: Section is automatically deleted when class is deleted

---

## Common Issues & Solutions

### Issue: Migration fails with "Table already exists"

**Solution**:
```bash
# Drop all tables and re-run
php artisan migrate:fresh

# Or reset and re-run
php artisan migrate:reset
php artisan migrate
```

### Issue: "Class not found" errors

**Solution**:
```bash
composer dump-autoload
php artisan config:clear
```

### Issue: Foreign key constraint fails

**Solution**: Check migration order (Step 4). Classes and sections must be created before students reference them.

### Issue: "SQLSTATE[HY000]: General error: 1215 Cannot add foreign key constraint"

**Causes**:
1. Referenced table doesn't exist yet (wrong migration order)
2. Column types don't match (e.g., unsignedBigInteger vs integer)
3. Referenced table uses different storage engine

**Solution**: Verify migration order and column types match

---

## Performance Tests

### Test Database Queries

```bash
php artisan tinker
```

```php
// Enable query log
\DB::enableQueryLog();

// Test complex relationship query
$student = \App\Models\Student::with([
    'user',
    'class',
    'section.classTeacher',
    'parents',
    'attendances',
    'examResults.exam'
])->first();

// View queries
\DB::getQueryLog();

exit
```

**Expected Result**: Queries use joins efficiently, no N+1 query problems

---

## Security Verification

### Test Role-Based Methods

```bash
php artisan tinker
```

```php
$admin = \App\Models\User::where('role', 'admin')->first();
echo "Is Admin: " . ($admin->isAdmin() ? 'Yes' : 'No') . "\n";
echo "Is Teacher: " . ($admin->isTeacher() ? 'Yes' : 'No') . "\n";

$teacher = \App\Models\User::where('role', 'teacher')->first();
echo "Is Teacher: " . ($teacher->isTeacher() ? 'Yes' : 'No') . "\n";

exit
```

**Expected Result**: Role methods return correct boolean values

---

## Final Checklist

- [ ] All PHP files have no syntax errors
- [ ] Autoload regenerated successfully
- [ ] All caches cleared
- [ ] Migration order is correct
- [ ] Database connection configured
- [ ] All migrations run successfully
- [ ] All 25 tables exist in database
- [ ] All models load without errors
- [ ] Test data creates successfully
- [ ] Relationships return correct data
- [ ] Foreign key cascades work correctly
- [ ] No N+1 query issues
- [ ] Role-based methods work correctly

---

## Getting Help

If you encounter issues:

1. **Check Laravel Logs**: `storage/logs/laravel.log`
2. **Enable Debug Mode**: Set `APP_DEBUG=true` in `.env`
3. **Check MySQL Logs**: `/var/log/mysql/error.log`
4. **Review Migration Files**: Ensure foreign keys reference existing tables
5. **Test in Tinker**: Use `php artisan tinker` for quick tests

---

## Production Deployment Checklist

Before deploying to production:

- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Generate new `APP_KEY` for production
- [ ] Configure production database credentials
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set proper file permissions (755 for directories, 644 for files)
- [ ] Configure backup system for database
- [ ] Set up SSL certificate
- [ ] Configure email settings for notifications
- [ ] Test all critical user flows
- [ ] Set up monitoring and error tracking

---

**Last Updated**: November 2025
**Version**: 2.0
**Contact**: umarwahab672@gmail.com
