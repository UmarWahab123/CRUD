# School Management System

A comprehensive Laravel-based School Management System with complete CRUD operations, role-based access control, and advanced features for managing students, teachers, classes, exams, attendance, fees, and more.

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [System Requirements](#system-requirements)
- [Installation](#installation)
- [Database Schema](#database-schema)
- [Modules](#modules)
- [User Roles](#user-roles)
- [Usage Guide](#usage-guide)

---

## Overview

This School Management System is built on Laravel 8 and provides a complete solution for educational institutions to manage:

- **Students**: Admission, profiles, attendance, grades, and fees
- **Teachers**: Employee records, subject assignments, attendance, and salary
- **Classes & Sections**: Hierarchical organization of students
- **Subjects**: Subject catalog with class associations
- **Examinations**: Exam scheduling, results, and grading
- **Attendance**: Daily tracking for both students and teachers
- **Fee Management**: Fee structure, payments, and receipts
- **Timetables**: Class schedules with teacher and room assignments
- **Assignments**: Homework management with due dates
- **Announcements**: School-wide or class-specific communications
- **Parents**: Parent profiles and student associations

---

## Features

### Core Features

✅ **Multi-User Role System**: Admin, Teacher, Student, Parent
✅ **Student Management**:
   - Complete student profiles with photos
   - Admission number and roll number generation
   - Class and section assignment
   - Parent/guardian information
   - Student status tracking (active, inactive, graduated, transferred)

✅ **Teacher Management**:
   - Employee ID generation
   - Qualification and designation tracking
   - Department and salary management
   - Subject assignments per class/section
   - Teacher attendance with check-in/check-out

✅ **Academic Management**:
   - Class and section organization
   - Subject catalog with class associations
   - Teacher-subject-class assignments
   - Timetable/schedule management

✅ **Examination System**:
   - Exam scheduling with date and time
   - Automatic grade calculation
   - Pass/fail status
   - Individual student performance tracking
   - Grade levels: A+, A, B, C, D, F

✅ **Attendance Management**:
   - Daily student attendance marking
   - Teacher attendance with check-in/out times
   - Multiple status options (present, absent, late, half-day, sick leave, excused)
   - Attendance reports

✅ **Fee Management**:
   - Class-wise fee structure
   - Multiple fee types (Tuition, Transport, Library, Sports)
   - Payment tracking with receipts
   - Payment methods (cash, card, online, cheque)
   - Fee status monitoring (paid, pending, partial, overdue)

✅ **Assignments**:
   - Assignment creation with attachments
   - Due date tracking
   - Class and section specific
   - Status management (active, completed, overdue, cancelled)

✅ **Announcements**:
   - Targeted communications (all, students, teachers, parents, specific class)
   - Priority levels (low, medium, high, urgent)
   - Publish and expiry dates
   - Created by admins/teachers

✅ **Data Import/Export**:
   - Excel/CSV import for bulk data entry
   - Export reports to Excel/CSV format

---

## System Requirements

- PHP >= 7.3 or 8.0+
- MySQL >= 5.7 or MariaDB >= 10.2
- Composer
- Node.js & NPM (for frontend assets)
- Laravel 8.12+

---

## Installation

### 1. Clone the Repository

```bash
git clone <repository-url>
cd CRUD
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install NPM dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy the environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration

Edit your `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=school_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 5. Run Migrations

```bash
php artisan migrate
```

This will create all necessary tables:
- users (with roles)
- students (enhanced)
- teachers (enhanced)
- classes
- sections
- subjects
- class_subject (pivot)
- teacher_subject (pivot)
- student_attendances
- teacher_attendances
- exams
- exam_results
- fees
- fee_payments
- timetables
- assignments
- announcements
- parents
- student_parent (pivot)

### 6. Seed Database (Optional)

```bash
php artisan db:seed
```

### 7. Build Frontend Assets

```bash
npm run dev
# or for production
npm run build
```

### 8. Start Development Server

```bash
php artisan serve
```

Visit `http://localhost:8000` in your browser.

---

## Database Schema

### Core Tables

#### users
- User authentication and role management
- Roles: admin, teacher, student, parent
- Fields: name, email, password, role, phone, address, profile_image, is_active

#### students
- Student profiles and academic information
- Foreign keys: user_id, class_id, section_id
- Key fields: admission_number, roll_number, date_of_birth, gender, status

#### teachers
- Teacher/employee information
- Foreign key: user_id
- Key fields: employee_id, qualification, designation, department, salary

#### classes
- Grade levels (Class 1, Class 2, etc.)
- Fields: name, numeric_name, description, is_active

#### sections
- Class divisions (Section A, B, C, etc.)
- Foreign keys: class_id, class_teacher_id
- Fields: name, capacity, is_active

#### subjects
- Subject catalog
- Fields: name, code, type, total_marks, passing_marks, is_active

### Relationship Tables

#### class_subject
- Maps subjects to classes
- Foreign keys: class_id, subject_id

#### teacher_subject
- Assigns teachers to subjects for specific class/section
- Foreign keys: teacher_id, subject_id, class_id, section_id

#### student_parent
- Links students to their parents/guardians
- Foreign keys: student_id, parent_id
- Pivot fields: relationship, is_primary_contact

### Academic Tables

#### exams
- Exam scheduling and configuration
- Foreign keys: class_id, subject_id
- Fields: name, exam_code, exam_date, start_time, end_time, total_marks, passing_marks, status

#### exam_results
- Student exam performance
- Foreign keys: exam_id, student_id
- Fields: obtained_marks, grade, percentage, status

#### student_attendances
- Daily student attendance
- Foreign keys: student_id, class_id, section_id
- Fields: date, status, remarks
- Unique: (student_id, date)

#### teacher_attendances
- Daily teacher attendance
- Foreign key: teacher_id
- Fields: date, status, check_in, check_out, remarks
- Unique: (teacher_id, date)

### Financial Tables

#### fees
- Fee structure per class
- Foreign key: class_id
- Fields: fee_type, amount, frequency, description

#### fee_payments
- Payment records
- Foreign keys: student_id, fee_id
- Fields: receipt_number, amount_paid, payment_date, payment_method, transaction_id, status

### Scheduling Tables

#### timetables
- Class schedules
- Foreign keys: class_id, section_id, subject_id, teacher_id
- Fields: day_of_week, start_time, end_time, room_number

#### assignments
- Homework assignments
- Foreign keys: class_id, section_id, subject_id, teacher_id
- Fields: title, description, assigned_date, due_date, total_marks, attachment, status

### Communication Tables

#### announcements
- School announcements
- Foreign keys: user_id, class_id (optional)
- Fields: title, content, target_audience, publish_date, expiry_date, priority

#### parents
- Parent/guardian information
- Foreign key: user_id
- Fields: father_name, father_phone, mother_name, mother_phone, address, emergency_contact

---

## Modules

### 1. User Management Module
**Purpose**: Manage system users with role-based access

**Models**: `User`

**Roles**:
- **Admin**: Full system access
- **Teacher**: Access to classes, students, exams, attendance
- **Student**: View grades, assignments, announcements
- **Parent**: View child's information, grades, attendance

**Key Methods**:
```php
$user->isAdmin()
$user->isTeacher()
$user->isStudent()
$user->isParent()
```

### 2. Student Management Module
**Purpose**: Complete student lifecycle management

**Model**: `Student`

**Relationships**:
- `belongsTo(User)` - Authentication account
- `belongsTo(SchoolClass)` - Current class
- `belongsTo(Section)` - Current section
- `belongsToMany(ParentModel)` - Parents/guardians
- `hasMany(StudentAttendance)` - Attendance records
- `hasMany(ExamResult)` - Exam results
- `hasMany(FeePayment)` - Payment history

**Key Features**:
- Admission number generation
- Roll number assignment
- Profile image upload
- Status tracking
- Parent association

### 3. Teacher Management Module
**Purpose**: Manage teaching staff and assignments

**Model**: `Teacher`

**Relationships**:
- `belongsTo(User)` - Authentication account
- `belongsToMany(Subject)` - Subjects taught (with class/section)
- `hasMany(Section)` - Classes where teacher is class teacher
- `hasMany(TeacherAttendance)` - Attendance records
- `hasMany(Timetable)` - Teaching schedule
- `hasMany(Assignment)` - Assignments created

**Key Features**:
- Employee ID generation
- Qualification tracking
- Subject assignments per class/section
- Salary management
- Full name accessor: `$teacher->full_name`

### 4. Class & Section Module
**Purpose**: Organize students hierarchically

**Models**: `SchoolClass`, `Section`

**SchoolClass Relationships**:
- `hasMany(Section)` - Class divisions
- `hasMany(Student)` - Enrolled students
- `belongsToMany(Subject)` - Subjects taught
- `hasMany(Fee)` - Fee structure
- `hasMany(Exam)` - Scheduled exams
- `hasMany(Timetable)` - Class schedule

**Section Relationships**:
- `belongsTo(SchoolClass)` - Parent class
- `belongsTo(Teacher)` - Class teacher
- `hasMany(Student)` - Section students
- `hasMany(Timetable)` - Section schedule

**Structure**:
```
Class 1
├── Section A (capacity: 30, class_teacher: Mrs. Smith)
├── Section B (capacity: 30, class_teacher: Mr. Johnson)
└── Section C (capacity: 25, class_teacher: Ms. Davis)

Class 2
├── Section A
└── Section B
```

### 5. Subject Module
**Purpose**: Manage subject catalog and assignments

**Model**: `Subject`

**Relationships**:
- `belongsToMany(SchoolClass)` - Classes where subject is taught
- `belongsToMany(Teacher)` - Teachers assigned (with class/section)
- `hasMany(Exam)` - Exams for subject
- `hasMany(Timetable)` - Schedule entries
- `hasMany(Assignment)` - Assignments

**Key Features**:
- Unique subject codes
- Type classification (theory, practical, both)
- Configurable total_marks and passing_marks
- Active/inactive status

### 6. Attendance Module
**Purpose**: Track daily attendance for students and teachers

**Models**: `StudentAttendance`, `TeacherAttendance`

**Student Attendance Statuses**:
- present
- absent
- late
- half_day
- sick_leave
- excused

**Teacher Attendance Features**:
- All student statuses plus: on_leave
- Check-in and check-out times
- Remarks field

**Unique Constraint**: One attendance record per student/teacher per date

### 7. Examination Module
**Purpose**: Manage exams and student results

**Models**: `Exam`, `ExamResult`

**Exam Fields**:
- Unique exam code
- Class and subject association
- Date, start time, end time
- Total marks and passing marks
- Instructions
- Status: scheduled, ongoing, completed, cancelled

**ExamResult Features**:
- Obtained marks
- Auto-calculated percentage
- Grade assignment (A+, A, B, C, D, F)
- Status: pass, fail, absent
- Grade calculation method: `$result->calculateGrade()`

**Grading Scale**:
- A+: >= 90%
- A: >= 80%
- B: >= 70%
- C: >= 60%
- D: >= 50%
- F: < 50%

### 8. Fee Management Module
**Purpose**: Manage fee structure and payments

**Models**: `Fee`, `FeePayment`

**Fee Types**:
- Tuition
- Transport
- Library
- Sports
- (Custom types allowed)

**Fee Frequencies**:
- monthly
- quarterly
- yearly
- one-time

**Payment Features**:
- Unique receipt number generation
- Payment methods: cash, card, online, cheque
- Transaction ID tracking
- Status: paid, pending, partial, overdue
- Payment date recording

### 9. Timetable Module
**Purpose**: Schedule management for classes

**Model**: `Timetable`

**Relationships**:
- `belongsTo(SchoolClass)`
- `belongsTo(Section)`
- `belongsTo(Subject)`
- `belongsTo(Teacher)`

**Fields**:
- day_of_week: monday through sunday
- start_time, end_time
- room_number
- is_active status

**Example Schedule**:
```
Class 1A - Monday
09:00-10:00: Mathematics (Mr. Smith, Room 101)
10:00-11:00: English (Mrs. Johnson, Room 102)
11:00-12:00: Science (Ms. Davis, Room 103)
```

### 10. Assignment Module
**Purpose**: Homework and assignment management

**Model**: `Assignment`

**Relationships**:
- `belongsTo(SchoolClass)`
- `belongsTo(Section)`
- `belongsTo(Subject)`
- `belongsTo(Teacher)` - Assignment creator

**Features**:
- Title and description
- File attachments
- Assigned date and due date
- Total marks
- Status: active, completed, overdue, cancelled

### 11. Announcement Module
**Purpose**: School-wide or targeted communications

**Model**: `Announcement`

**Target Audiences**:
- all
- students
- teachers
- parents
- specific_class

**Priority Levels**:
- low
- medium
- high
- urgent

**Features**:
- Publish date and expiry date
- Created by user (admin/teacher)
- Class-specific option
- Active/inactive status

### 12. Parent Module
**Purpose**: Parent/guardian information and student associations

**Model**: `ParentModel`

**Relationships**:
- `belongsTo(User)` - Authentication account
- `belongsToMany(Student)` - Children (with relationship type and primary contact flag)

**Fields**:
- Father information: name, phone, email, occupation
- Mother information: name, phone, email, occupation
- Address
- Emergency contact

**Pivot Fields**:
- relationship: father, mother, guardian
- is_primary_contact: boolean

---

## User Roles

### Admin
**Access Level**: Full system access

**Capabilities**:
- Manage all users (create, edit, delete)
- Manage classes, sections, subjects
- View and edit all student and teacher data
- Access all financial records
- Create announcements
- Generate reports
- System configuration

### Teacher
**Access Level**: Limited administrative access

**Capabilities**:
- View assigned classes and students
- Mark student attendance
- Record exam results
- Create and manage assignments
- View timetables
- Create announcements for assigned classes
- Update own profile

### Student
**Access Level**: Read-only with personal data

**Capabilities**:
- View own profile
- View grades and exam results
- View attendance records
- View assignments
- View timetables
- View announcements
- View fee payment history

### Parent
**Access Level**: Read-only for associated students

**Capabilities**:
- View children's profiles
- View children's grades
- View children's attendance
- View children's assignments
- View announcements
- View fee payment status

---

## Usage Guide

### Setting Up the System

#### 1. Create Admin User

After installation, create the first admin user via Tinker:

```bash
php artisan tinker
```

```php
$user = \App\Models\User::create([
    'name' => 'Admin User',
    'email' => 'admin@school.com',
    'password' => bcrypt('password'),
    'role' => 'admin',
    'is_active' => true
]);
```

#### 2. Create Classes and Sections

```php
// Create a class
$class = \App\Models\SchoolClass::create([
    'name' => 'Class 1',
    'numeric_name' => '1',
    'description' => 'First grade',
    'is_active' => true
]);

// Create sections for the class
$sectionA = \App\Models\Section::create([
    'class_id' => $class->id,
    'name' => 'A',
    'capacity' => 30,
    'is_active' => true
]);
```

#### 3. Create Subjects

```php
$math = \App\Models\Subject::create([
    'name' => 'Mathematics',
    'code' => 'MATH101',
    'description' => 'Basic Mathematics',
    'type' => 'theory',
    'total_marks' => 100,
    'passing_marks' => 40,
    'is_active' => true
]);

// Assign subject to class
$class->subjects()->attach($math->id);
```

#### 4. Register a Teacher

```php
// Create user account
$teacherUser = \App\Models\User::create([
    'name' => 'John Smith',
    'email' => 'john.smith@school.com',
    'password' => bcrypt('password'),
    'role' => 'teacher',
    'phone' => '123-456-7890',
    'is_active' => true
]);

// Create teacher profile
$teacher = \App\Models\Teacher::create([
    'user_id' => $teacherUser->id,
    'employee_id' => 'EMP001',
    'firstname' => 'John',
    'lastname' => 'Smith',
    'email' => 'john.smith@school.com',
    'phone' => '123-456-7890',
    'qualification' => 'M.Sc. Mathematics',
    'designation' => 'Senior Teacher',
    'department' => 'Mathematics',
    'date_of_joining' => now(),
    'salary' => 50000,
    'status' => 'active'
]);

// Assign teacher to subject for specific class/section
$teacher->subjects()->attach($math->id, [
    'class_id' => $class->id,
    'section_id' => $sectionA->id
]);
```

#### 5. Register a Student

```php
// Create parent user account
$parentUser = \App\Models\User::create([
    'name' => 'Jane Doe',
    'email' => 'jane.doe@parent.com',
    'password' => bcrypt('password'),
    'role' => 'parent',
    'is_active' => true
]);

// Create parent profile
$parent = \App\Models\ParentModel::create([
    'user_id' => $parentUser->id,
    'father_name' => 'John Doe',
    'father_phone' => '123-456-7890',
    'father_email' => 'john.doe@parent.com',
    'mother_name' => 'Jane Doe',
    'mother_phone' => '123-456-7891',
    'mother_email' => 'jane.doe@parent.com',
    'address' => '123 Main St, City',
    'emergency_contact' => '123-456-7890'
]);

// Create student user account
$studentUser = \App\Models\User::create([
    'name' => 'Alice Doe',
    'email' => 'alice.doe@student.com',
    'password' => bcrypt('password'),
    'role' => 'student',
    'is_active' => true
]);

// Create student profile
$student = \App\Models\Student::create([
    'user_id' => $studentUser->id,
    'class_id' => $class->id,
    'section_id' => $sectionA->id,
    'name' => 'Alice Doe',
    'admission_number' => 'ADM2024001',
    'roll_number' => '1',
    'date_of_birth' => '2010-05-15',
    'gender' => 'female',
    'blood_group' => 'A+',
    'email' => 'alice.doe@student.com',
    'phone' => '123-456-7892',
    'address' => '123 Main St, City',
    'admission_date' => now(),
    'status' => 'active'
]);

// Link student to parent
$student->parents()->attach($parent->id, [
    'relationship' => 'father',
    'is_primary_contact' => true
]);
```

### Managing Daily Operations

#### Mark Student Attendance

```php
\App\Models\StudentAttendance::create([
    'student_id' => $student->id,
    'class_id' => $class->id,
    'section_id' => $sectionA->id,
    'date' => today(),
    'status' => 'present',
    'remarks' => null
]);
```

#### Create and Schedule an Exam

```php
$exam = \App\Models\Exam::create([
    'name' => 'Mid Term Exam',
    'exam_code' => 'MID2024-MATH-1',
    'class_id' => $class->id,
    'subject_id' => $math->id,
    'exam_date' => '2024-12-15',
    'start_time' => '09:00:00',
    'end_time' => '11:00:00',
    'total_marks' => 100,
    'passing_marks' => 40,
    'instructions' => 'Use blue or black pen only',
    'status' => 'scheduled'
]);
```

#### Record Exam Result

```php
$result = \App\Models\ExamResult::create([
    'exam_id' => $exam->id,
    'student_id' => $student->id,
    'obtained_marks' => 85,
    'percentage' => 85.00,
    'grade' => 'A',
    'status' => 'pass',
    'remarks' => 'Excellent performance'
]);
```

#### Create Fee Payment

```php
\App\Models\FeePayment::create([
    'student_id' => $student->id,
    'fee_id' => $tuitionFee->id,
    'receipt_number' => 'REC2024001',
    'amount_paid' => 5000.00,
    'payment_date' => today(),
    'payment_method' => 'card',
    'transaction_id' => 'TXN123456',
    'status' => 'paid'
]);
```

#### Create Assignment

```php
\App\Models\Assignment::create([
    'title' => 'Chapter 1 Exercises',
    'description' => 'Complete all exercises from page 15-20',
    'class_id' => $class->id,
    'section_id' => $sectionA->id,
    'subject_id' => $math->id,
    'teacher_id' => $teacher->id,
    'assigned_date' => today(),
    'due_date' => today()->addDays(7),
    'total_marks' => 10,
    'status' => 'active'
]);
```

#### Create Announcement

```php
\App\Models\Announcement::create([
    'title' => 'School Holiday Notice',
    'content' => 'School will be closed on Monday for National Holiday',
    'user_id' => $adminUser->id,
    'target_audience' => 'all',
    'publish_date' => today(),
    'expiry_date' => today()->addDays(7),
    'priority' => 'high',
    'is_active' => true
]);
```

### Querying Data

#### Get All Students in a Class

```php
$students = $class->students()->with('section', 'parents')->get();
```

#### Get Teacher's Schedule

```php
$schedule = $teacher->timetables()
    ->with('class', 'section', 'subject')
    ->where('is_active', true)
    ->orderBy('day_of_week')
    ->orderBy('start_time')
    ->get();
```

#### Get Student's Exam Results

```php
$results = $student->examResults()
    ->with('exam.subject')
    ->get();
```

#### Get Attendance Report

```php
$attendance = StudentAttendance::where('class_id', $class->id)
    ->whereMonth('date', now()->month)
    ->with('student')
    ->get();
```

#### Get Unpaid Fees

```php
$unpaidFees = FeePayment::where('student_id', $student->id)
    ->where('status', 'pending')
    ->with('fee')
    ->get();
```

---

## API Endpoints (To Be Implemented)

Future versions will include RESTful API endpoints for:

- `/api/auth/login` - User authentication
- `/api/students` - Student CRUD
- `/api/teachers` - Teacher CRUD
- `/api/classes` - Class management
- `/api/attendance` - Attendance marking
- `/api/exams` - Exam management
- `/api/results` - Exam results
- `/api/fees` - Fee management
- `/api/announcements` - Announcements

---

## Security Features

- Password hashing with bcrypt
- CSRF protection
- SQL injection prevention via Eloquent ORM
- Role-based access control
- Email verification (can be enabled)
- Secure session management

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Write/update tests
5. Submit a pull request

---

## License

This project is open-sourced software licensed under the MIT license.

---

## Support

For support, please contact:
- Email: umarwahab672@gmail.com
- Create an issue on GitHub

---

## Changelog

### Version 2.0 (Current)
- Complete school management system implementation
- 19 database tables with relationships
- 13 models with full relationships
- Role-based access control
- Student, Teacher, Class, Subject modules
- Attendance management
- Examination system
- Fee management
- Timetable scheduling
- Assignment management
- Announcements
- Parent portal

### Version 1.0
- Basic CRUD for Students, Employees, Teachers
- Excel import/export
- File upload features
- Contact form

---

## Roadmap

Future enhancements planned:
- [ ] Web-based admin panel with UI
- [ ] RESTful API implementation
- [ ] Mobile app integration
- [ ] Real-time notifications
- [ ] SMS integration for attendance alerts
- [ ] Online exam module
- [ ] Library management
- [ ] Transport management
- [ ] Hostel management
- [ ] Payroll system
- [ ] Advanced reporting and analytics
- [ ] Multi-language support
- [ ] Multi-tenancy for multiple schools

---

## Credits

Developed by: Umar Wahab
Email: umarwahab672@gmail.com
Framework: Laravel 8
Database: MySQL

---

**Last Updated**: November 2025
