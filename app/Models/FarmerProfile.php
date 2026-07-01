<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FarmerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_image', // Fillable parameter added
        'farm_location',
        'crop_type',
        'land_size',
        'contact_details',
        'farming_history',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}