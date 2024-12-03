<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'spec_id'];

    // Relationship to specializations
    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'spec_id');
    }

    // Relationship to resumes
    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }
}
