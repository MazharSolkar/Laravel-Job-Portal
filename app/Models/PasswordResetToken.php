<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;
    // Disable automatic timestamps
    public $timestamps = false;

    protected $fillable = ['email', 'token', 'created_at'];
}
