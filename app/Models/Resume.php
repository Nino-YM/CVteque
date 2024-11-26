<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'spec_id', 'file_path', 'uploaded_at'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * A resume belongs to a specialization.
     */
    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'spec_id');
    }
}
