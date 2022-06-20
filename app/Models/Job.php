<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static first()
 */
class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'title', 'description', 'companyName', 'expirationDate', 'email', 'phone'
    ];
}
