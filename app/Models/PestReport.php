<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PestReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'crop_type',
        'pest_name',
        'severity',
        'description',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}