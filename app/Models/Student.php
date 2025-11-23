<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_id',
        'section_id',
        'name',
        'admission_number',
        'roll_number',
        'date_of_birth',
        'gender',
        'blood_group',
        'email',
        'phone',
        'address',
        'profileimage',
        'admission_date',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'admission_date' => 'date',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function parents()
    {
        return $this->belongsToMany(ParentModel::class, 'student_parent')
                    ->withPivot('relationship', 'is_primary_contact')
                    ->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function feePayments()
    {
        return $this->hasMany(FeePayment::class);
    }
}
