# School Management System - API Structure & Relationships

Quick reference for understanding the database structure, relationships, and how to use the system.

## Table Relationships Overview

```
users (authentication)
├── has one → student
├── has one → teacher
├── has one → parent (ParentModel)
└── has many → announcements

classes (SchoolClass)
├── has many → sections
├── has many → students
├── has many → fees
├── has many → exams
├── has many → timetables
├── has many → assignments
├── has many → announcements
└── belongs to many → subjects (via class_subject)

sections
├── belongs to → class (SchoolClass)
├── belongs to → class_teacher (Teacher)
├── has many → students
├── has many → timetables
├── has many → assignments
└── has many → student_attendances

subjects
├── belongs to many → classes (via class_subject)
├── belongs to many → teachers (via teacher_subject with class_id, section_id)
├── has many → exams
├── has many → timetables
└── has many → assignments

students
├── belongs to → user
├── belongs to → class (SchoolClass)
├── belongs to → section
├── belongs to many → parents (via student_parent)
├── has many → student_attendances
├── has many → exam_results
└── has many → fee_payments

teachers
├── belongs to → user
├── belongs to many → subjects (via teacher_subject)
├── has many → sections (as class_teacher)
├── has many → teacher_attendances
├── has many → timetables
└── has many → assignments

parents (ParentModel)
├── belongs to → user
└── belongs to many → students (via student_parent)

exams
├── belongs to → class (SchoolClass)
├── belongs to → subject
└── has many → exam_results

exam_results
├── belongs to → exam
└── belongs to → student

student_attendances
├── belongs to → student
├── belongs to → class (SchoolClass)
└── belongs to → section

teacher_attendances
└── belongs to → teacher

fees
├── belongs to → class (SchoolClass)
└── has many → fee_payments

fee_payments
├── belongs to → student
└── belongs to → fee

timetables
├── belongs to → class (SchoolClass)
├── belongs to → section
├── belongs to → subject
└── belongs to → teacher

assignments
├── belongs to → class (SchoolClass)
├── belongs to → section
├── belongs to → subject
└── belongs to → teacher

announcements
├── belongs to → user (creator)
└── belongs to → class (optional, if specific_class)
```

---

## Core Workflows

### 1. Student Enrollment Workflow

```php
// Step 1: Create parent user account
$parentUser = User::create([
    'name' => 'Parent Name',
    'email' => 'parent@example.com',
    'password' => bcrypt('password'),
    'role' => 'parent',
]);

// Step 2: Create parent profile
$parent = ParentModel::create([
    'user_id' => $parentUser->id,
    'father_name' => 'Father Name',
    'father_phone' => '1234567890',
    'mother_name' => 'Mother Name',
    'mother_phone' => '0987654321',
]);

// Step 3: Create student user account
$studentUser = User::create([
    'name' => 'Student Name',
    'email' => 'student@example.com',
    'password' => bcrypt('password'),
    'role' => 'student',
]);

// Step 4: Create student profile with class assignment
$student = Student::create([
    'user_id' => $studentUser->id,
    'class_id' => $classId,
    'section_id' => $sectionId,
    'name' => 'Student Name',
    'admission_number' => 'ADM2024001',
    'admission_date' => now(),
    'status' => 'active',
]);

// Step 5: Link student to parent
$student->parents()->attach($parent->id, [
    'relationship' => 'father',
    'is_primary_contact' => true,
]);
```

### 2. Teacher Assignment Workflow

```php
// Step 1: Create teacher user
$teacherUser = User::create([
    'name' => 'Teacher Name',
    'email' => 'teacher@example.com',
    'password' => bcrypt('password'),
    'role' => 'teacher',
]);

// Step 2: Create teacher profile
$teacher = Teacher::create([
    'user_id' => $teacherUser->id,
    'employee_id' => 'EMP001',
    'firstname' => 'John',
    'lastname' => 'Doe',
    'email' => 'teacher@example.com',
    'phone' => '1234567890',
    'status' => 'active',
]);

// Step 3: Assign subjects to teacher for specific classes
$teacher->subjects()->attach($subjectId, [
    'class_id' => $classId,
    'section_id' => $sectionId,
]);

// Step 4: Assign as class teacher (optional)
$section->update(['class_teacher_id' => $teacher->id]);
```

### 3. Attendance Marking Workflow

```php
// Mark student attendance
StudentAttendance::create([
    'student_id' => $studentId,
    'class_id' => $classId,
    'section_id' => $sectionId,
    'date' => today(),
    'status' => 'present', // or absent, late, half_day, sick_leave, excused
]);

// Mark teacher attendance
TeacherAttendance::create([
    'teacher_id' => $teacherId,
    'date' => today(),
    'status' => 'present',
    'check_in' => '08:00:00',
    'check_out' => '17:00:00',
]);
```

### 4. Exam Management Workflow

```php
// Step 1: Create exam
$exam = Exam::create([
    'name' => 'Mid Term Exam',
    'exam_code' => 'MTE2024-MATH-10',
    'class_id' => $classId,
    'subject_id' => $subjectId,
    'exam_date' => '2024-12-15',
    'start_time' => '09:00',
    'end_time' => '12:00',
    'total_marks' => 100,
    'passing_marks' => 40,
    'status' => 'scheduled',
]);

// Step 2: Record student result
$result = ExamResult::create([
    'exam_id' => $exam->id,
    'student_id' => $studentId,
    'obtained_marks' => 85,
    'percentage' => 85.00,
    'grade' => null, // Will be calculated
]);

// Step 3: Calculate and update grade
$result->grade = $result->calculateGrade();
$result->status = ($result->percentage >= $exam->passing_marks) ? 'pass' : 'fail';
$result->save();
```

### 5. Fee Payment Workflow

```php
// Step 1: Create fee structure for class
$fee = Fee::create([
    'class_id' => $classId,
    'fee_type' => 'Tuition',
    'amount' => 5000.00,
    'frequency' => 'monthly',
]);

// Step 2: Record payment
$payment = FeePayment::create([
    'student_id' => $studentId,
    'fee_id' => $fee->id,
    'receipt_number' => 'REC' . time(),
    'amount_paid' => 5000.00,
    'payment_date' => today(),
    'payment_method' => 'card',
    'status' => 'paid',
]);
```

---

## Common Queries

### Get Student's Complete Profile

```php
$student = Student::with([
    'user',
    'class',
    'section.classTeacher',
    'parents',
])->find($studentId);

echo "Name: " . $student->name;
echo "Class: " . $student->class->name;
echo "Section: " . $student->section->name;
echo "Class Teacher: " . $student->section->classTeacher->full_name;
echo "Father: " . $student->parents->first()->father_name;
```

### Get Class Timetable

```php
$timetable = Timetable::where('class_id', $classId)
    ->where('section_id', $sectionId)
    ->where('is_active', true)
    ->with(['subject', 'teacher'])
    ->orderBy('day_of_week')
    ->orderBy('start_time')
    ->get()
    ->groupBy('day_of_week');

foreach ($timetable as $day => $periods) {
    echo ucfirst($day) . ":\n";
    foreach ($periods as $period) {
        echo "  " . $period->start_time . " - " . $period->end_time;
        echo ": " . $period->subject->name;
        echo " (" . $period->teacher->full_name . ")\n";
    }
}
```

### Get Student Attendance Report

```php
$attendance = StudentAttendance::where('student_id', $studentId)
    ->whereMonth('date', now()->month)
    ->get();

$present = $attendance->where('status', 'present')->count();
$absent = $attendance->where('status', 'absent')->count();
$total = $attendance->count();

$percentage = $total > 0 ? ($present / $total) * 100 : 0;

echo "Attendance: {$present}/{$total} ({$percentage}%)";
```

### Get Student Exam Results

```php
$results = ExamResult::where('student_id', $studentId)
    ->with('exam.subject')
    ->orderBy('created_at', 'desc')
    ->get();

foreach ($results as $result) {
    echo $result->exam->subject->name . ": ";
    echo $result->obtained_marks . "/" . $result->exam->total_marks;
    echo " (" . $result->grade . " - " . $result->status . ")\n";
}
```

### Get Teacher Schedule

```php
$schedule = Timetable::where('teacher_id', $teacherId)
    ->where('is_active', true)
    ->with(['class', 'section', 'subject'])
    ->orderBy('day_of_week')
    ->orderBy('start_time')
    ->get();

foreach ($schedule as $slot) {
    echo $slot->day_of_week . " " . $slot->start_time . ": ";
    echo $slot->class->name . "-" . $slot->section->name;
    echo " (" . $slot->subject->name . ")\n";
}
```

### Get Pending Fees

```php
$pendingFees = FeePayment::where('student_id', $studentId)
    ->whereIn('status', ['pending', 'partial', 'overdue'])
    ->with('fee')
    ->get();

$totalPending = $pendingFees->sum(function($payment) {
    return $payment->fee->amount - $payment->amount_paid;
});

echo "Total Pending: $" . number_format($totalPending, 2);
```

---

## Validation Rules Reference

### User Registration

```php
[
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users,email',
    'password' => 'required|min:8|confirmed',
    'role' => 'required|in:admin,teacher,student,parent',
]
```

### Student Admission

```php
[
    'name' => 'required|string|max:255',
    'admission_number' => 'required|unique:students,admission_number',
    'class_id' => 'required|exists:classes,id',
    'section_id' => 'required|exists:sections,id',
    'date_of_birth' => 'nullable|date|before:today',
    'gender' => 'nullable|in:male,female,other',
    'email' => 'nullable|email|unique:students,email',
]
```

### Teacher Assignment

```php
[
    'employee_id' => 'required|unique:teachers,employee_id',
    'firstname' => 'required|string|max:255',
    'lastname' => 'required|string|max:255',
    'email' => 'required|email|unique:teachers,email',
    'phone' => 'required|string|max:20',
]
```

### Exam Creation

```php
[
    'name' => 'required|string|max:255',
    'exam_code' => 'required|unique:exams,exam_code',
    'class_id' => 'required|exists:classes,id',
    'subject_id' => 'required|exists:subjects,id',
    'exam_date' => 'required|date',
    'start_time' => 'required|date_format:H:i',
    'end_time' => 'required|date_format:H:i|after:start_time',
    'total_marks' => 'required|integer|min:1',
    'passing_marks' => 'required|integer|min:1|lte:total_marks',
]
```

---

## Enum Values Reference

### User Roles
- `admin` - Full system access
- `teacher` - Class and student management
- `student` - View own data
- `parent` - View children's data

### Student Status
- `active` - Currently enrolled
- `inactive` - Temporarily inactive
- `graduated` - Completed studies
- `transferred` - Moved to another school

### Teacher Status
- `active` - Currently employed
- `inactive` - Temporarily inactive
- `on_leave` - On leave

### Attendance Status (Student)
- `present` - Attended
- `absent` - Did not attend
- `late` - Arrived late
- `half_day` - Half day attendance
- `sick_leave` - Medical leave
- `excused` - Excused absence

### Attendance Status (Teacher)
- All student statuses plus:
- `on_leave` - Official leave

### Exam Status
- `scheduled` - Not yet conducted
- `ongoing` - Currently in progress
- `completed` - Finished
- `cancelled` - Cancelled

### Exam Result Status
- `pass` - Passed the exam
- `fail` - Failed the exam
- `absent` - Did not appear

### Fee Payment Status
- `paid` - Fully paid
- `pending` - Not paid
- `partial` - Partially paid
- `overdue` - Payment overdue

### Assignment Status
- `active` - Currently active
- `completed` - Completed
- `overdue` - Past due date
- `cancelled` - Cancelled

### Announcement Priority
- `low` - Low priority
- `medium` - Medium priority
- `high` - High priority
- `urgent` - Urgent

### Announcement Target Audience
- `all` - Everyone
- `students` - Students only
- `teachers` - Teachers only
- `parents` - Parents only
- `specific_class` - Specific class (requires class_id)

---

## Database Indexes

### Automatically Created Indexes

Foreign keys automatically create indexes:
- All `*_id` columns have indexes
- All `unique()` constraints create indexes

### Recommended Additional Indexes

```sql
-- For faster student searches
CREATE INDEX idx_students_admission_number ON students(admission_number);
CREATE INDEX idx_students_status ON students(status);

-- For attendance queries
CREATE INDEX idx_student_attendances_date ON student_attendances(date);
CREATE INDEX idx_teacher_attendances_date ON teacher_attendances(date);

-- For exam queries
CREATE INDEX idx_exams_date ON exams(exam_date);
CREATE INDEX idx_exams_status ON exams(status);

-- For fee queries
CREATE INDEX idx_fee_payments_date ON fee_payments(payment_date);
CREATE INDEX idx_fee_payments_status ON fee_payments(status);
```

---

## Performance Tips

1. **Always use eager loading** for relationships:
   ```php
   // Good
   $students = Student::with('class', 'section')->get();

   // Bad (N+1 problem)
   $students = Student::all();
   foreach ($students as $student) {
       echo $student->class->name; // Separate query for each
   }
   ```

2. **Use select() to limit columns**:
   ```php
   $students = Student::select('id', 'name', 'admission_number')->get();
   ```

3. **Paginate large result sets**:
   ```php
   $students = Student::paginate(50);
   ```

4. **Cache frequently accessed data**:
   ```php
   $classes = Cache::remember('classes', 3600, function () {
       return SchoolClass::where('is_active', true)->get();
   });
   ```

---

**Last Updated**: November 2025
**Version**: 2.0
