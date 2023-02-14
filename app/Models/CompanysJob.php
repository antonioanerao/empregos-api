<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static first()
 */
class CompanysJob extends Model
{
    protected $table = 'companys_job';
    protected $fillable = [
        'title', 'description', 'companyName', 'expirationDate', 'email', 'phone', 'status'
    ];

    public function setExpirationDateAttribute($expirationDate) {
        $this->attributes['expirationDate'] = Carbon::createFromFormat('d/m/Y', $expirationDate)->format('Y-m-d');
    }

    protected static function booted()
    {
        static::creating(function ($job) {
            $job->user_id = auth()->user()->id;
        });
    }
}
