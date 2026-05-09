<?php

namespace App\Models;

use App\Services\StudentIdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'custom_id',
        'first_name',
        'middle_name',
        'last_name',
        'contact_number',
    ];

    protected static function booted(): void
    {
        static::creating(function (Student $student) {
            if (empty($student->custom_id)) {
                $student->custom_id = StudentIdGenerator::generate();
            }
        });
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class, 'student_teacher');
    }

    public function guardians(): BelongsToMany
    {
        return $this->belongsToMany(Guardian::class, 'guardian_student')
            ->withPivot('relationship')
            ->withTimestamps();
    }

    public function getFullNameAttribute(): string
    {
        return collect([$this->first_name, $this->middle_name, $this->last_name])
            ->filter()
            ->implode(' ');
    }
}
