<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id', 'service_id', 'status', 'address', 'created_at', 'updated_at'
    ];

    CONST status = [
    	1 => 'PENDING',
    	2 => 'ACTIVE',
    	3 => 'PAYMENT',
    ];


    public function getStatusTextAttribute() {
    	return $this->status[$this->status];
    }

    public function service() {
    	return $this->belongsTo('App\Models\Service');
    }

    public function user() {
    	return $this->belongsTo('App\Models\User');
    }

    public function slot() {
    	return $this->hasMany('App\Models\BookingSlot');
    }
}
