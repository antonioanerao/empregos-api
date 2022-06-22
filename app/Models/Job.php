<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static first()
 */
class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'companyName', 'expirationDate', 'email', 'phone', 'status'
    ];

    public function setExpirationDateAttribute($expirationDate) {
        $this->attributes['expirationDate'] = Carbon::createFromFormat('d/m/Y', $expirationDate)->format('d-m-Y');
    }

    protected static function booted()
    {
        static::creating(function ($job) {
            $job->user_id = auth()->user()->id;
        });

    }
}
