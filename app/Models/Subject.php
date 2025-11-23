<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'type',
        'total_marks',
        'passing_marks',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function classes()
    {
        return $this->belongsToMany(SchoolClass::class, 'class_subject')
                    ->withTimestamps();
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'teacher_subject')
                    ->withPivot('class_id', 'section_id')
                    ->withTimestamps();
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function timetables()
    {
        return $this->hasMany(Timetable::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
