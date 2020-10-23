<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookingService;

class BookingController extends Controller
{
	protected $bookingService;
	public function __construct(BookingService $bookingService) {
		$this->bookingService = $bookingService;
	}

    public function index(Request $request) {
    	if($request->has('user_id')) {
    		$user_id = $request->get('user_id');
    	} else {
    		$user_id = 1;
    	}
        $status = $this->getStatusByUri($request);
    	$usersServices = $this->bookingService->listService($user_id);
        $count = $this->bookingService->getBookingCount($usersServices->first()->id, $status);
        $overallCount = $this->bookingService->getAllCount();

    	return view('main', compact(['usersServices', 'count', 'overallCount']));
    }

    public function getBookings(Request $request) {
        $request->validate([
            'service_id' => 'required',
            'uri' => 'required'
        ]);
        $status = $this->getStatusByUri(null, '/'.$request->get('uri'));
        $bookings = $this->bookingService->getBookingsByService($request, $status);

        return view('booking', compact('bookings'));
    }

    public function getBookingCount(Request $request) {
        $status = $this->getStatusByUri($request);
        return $this->bookingService->getBookingCount($request->get('service_id'), $status);
    }

    public function getStatusByUri($request, $uri=null) {
        if(is_null($uri)) {
            $uri = $request->getRequestUri();
        }
        switch ($uri) {
            case '/bookings/request':
                return 'PENDING';
                break;
            case '/bookings/service':
                return 'ACTIVE';
                break;
            case '/bookings/payment':
                return 'PAYMENT';
                break;
            
            default:
                return 'PENDING';
                break;
        }
    }

    public function statusChange(Request $request) {
        $request->validate([
            'id' => 'required',
            'status' => 'required'
        ]);

        return $this->bookingService->updateStatus($request);
    }
}
