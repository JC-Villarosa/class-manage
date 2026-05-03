<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'contact_number',
    ];

    public function guardians()
    {
        return $this->belongsToMany(Guardian::class, 'guardian_student')
            ->withPivot('relationship')
            ->withTimeStamps();
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'student_teacher')
            ->withTimeStamps();
    }

}
