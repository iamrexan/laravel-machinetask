<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function() {
	return redirect()->route('request');
});

Route::group(['prefix' => 'bookings', 'namespace' => 'App\Http\Controllers'], function() {
	Route::get('/request', 'BookingController@index')->name('request');
	Route::get('/service', 'BookingController@index')->name('service');
	Route::get('/payment', 'BookingController@index')->name('payment');

	Route::post('get-bookings', 'BookingController@getBookings')->name('get-bookings');
	Route::post('booking-count', 'BookingController@getBookingCount')->name('get-booking-count');

	Route::post('update-status', 'BookingController@statusChange')->name('update-status');
});

// To seed fresh Data through url
Route::get('general/seed', function() {
	Artisan::call('db:seed');
});