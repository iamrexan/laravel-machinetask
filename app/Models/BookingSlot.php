<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSlot extends Model
{
    use HasFactory;

    protected $fillable = [
    	'booking_id', 'slot_date', 'slot_timing', 'created_at', 'updated_at'
    ];

    public function getBookingSlotDateAttribute() {
    	return Carbon::parse($this->slot_date)->format('l, F jS, Y');
    }
}
