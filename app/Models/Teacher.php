<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'contact_number',
        'address'
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_teacher')
            ->withTimeStamps();
    }
    
}
