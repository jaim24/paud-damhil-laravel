<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;
use App\Models\Student;

class SchoolClass extends Model
{
    protected $fillable = [
        'name',
        'age_group',
        'teacher_id',
        'academic_year',
        'learning_focus'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_group', 'name');
    }

    public function getStudentCountAttribute()
    {
        return $this->students()->count();
    }
}
