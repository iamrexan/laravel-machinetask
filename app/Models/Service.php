<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id', 'title', 'type', 'description', 'thumnail_url', 'price', 'currency_id', 'price_type', 'created_at', 'updated_at'
    ];

    public function booking() {
    	return $this->hasMany('App\Models\Booking');
    }
}
