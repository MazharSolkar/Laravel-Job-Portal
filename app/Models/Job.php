<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'job_type_id',
        'user_id',
        'vacancy',
        'job_location',
        'company_location',
        'description',
        'company_name',
        'experience',
        'salary',
        'benefits',
        'responsibility',
        'keywords',
        'experience',
        'company_website'

    ];
}
