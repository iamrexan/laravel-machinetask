<?php

namespace App\Services;

use App\Models\Service;
use App\Models\Booking;

class BookingService
{
	public function listService($user_id) {
		return Service::where('user_id', $user_id)->get();
	}

	public function getBookingsByService($request, $status) {
		return Booking::where([
			'service_id' => $request->get('service_id'), 
			'status' => array_flip(Booking::status)[$status]
		])
		->with(['user', 'slot'])
		->offset($request->get('offset'))
		->take($request->get('limit'))
		->get();
	}

	public function getBookingCount($service_id, $status) {
		return Booking::where([
			'service_id' => $service_id,
			'status' => array_flip(Booking::status)[$status]
		])
		->count();
	}

	public function getAllCount() {
		$data = [];
		$data['pending'] = Booking::where('status', array_flip(Booking::status)['PENDING'])->count();
		$data['active'] = Booking::where('status', array_flip(Booking::status)['ACTIVE'])->count();
		$data['payment'] = Booking::where('status', array_flip(Booking::status)['PAYMENT'])->count();

		return $data;
	}

	public function updateStatus($request) {
		$data['data'] = Booking::find($request->id)->update([
			'status' => array_flip(Booking::status)[$request->status]
		]);
		$data['status'] = 'success';
		$data['message'] = '';

		return $data;
	}
}