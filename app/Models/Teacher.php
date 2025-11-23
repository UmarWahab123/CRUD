<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'firstname',
        'lastname',
        'email',
        'phone',
        'qualification',
        'designation',
        'department',
        'date_of_joining',
        'salary',
        'address',
        'profile_image',
        'status',
    ];

    protected $casts = [
        'date_of_joining' => 'date',
        'salary' => 'decimal:2',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject')
                    ->withPivot('class_id', 'section_id')
                    ->withTimestamps();
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'class_teacher_id');
    }

    public function attendances()
    {
        return $this->hasMany(TeacherAttendance::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    public function getFullNameAttribute()
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
