<!DOCTYPE html>
<html>
<head>
	<title>Webdura Main</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="/css/app.css">

	<!-- CSS -->
	<link rel="stylesheet" href="{{ url('css/alertify.min.css') }}"/>
</head>
<body>
	@php $uri = Request::path(); @endphp
	<div class="container-fluid my-5 custom-container">
		<nav class="navbar cardheader-custom mx-auto">
			<div class="d-inline-block">
				<ul class="nav navbar-nav d-inline-block">
					<li class="list-inline-item mx-lg-4 mx-md-4"><i class="fa fa-chevron-left"></i></li>
					<li class="list-inline-item mx-lg-4 mx-md-4 mx-sm-4"><a href="{{ route('request') }}" class="{{ ($uri == 'bookings/request') ? 'active' : '' }}{{ ($overallCount['pending'] > 0) ? ' red-dot' : '' }}">Requests</a></li>
					<li class="list-inline-item mx-lg-4 mx-md-4 mx-sm-4"><a href="{{ route('service') }}" class="{{ ($uri == 'bookings/service') ? 'active' : '' }}{{ ($overallCount['active'] > 0) ? ' red-dot' : '' }}">Services</a></li>
					<li class="list-inline-item mx-lg-4 mx-md-4 mx-sm-4"><a href="{{ route('payment') }}" class="{{ ($uri == 'bookings/payment') ? 'active' : '' }}{{ ($overallCount['payment'] > 0) ? ' red-dot' : '' }}">Payments</a></li>
				</ul>
			</div>
		</nav>
		<div class="card">
			<div class="cord-body">
				<div class="slider-container">
				@foreach($usersServices as $service)
				  <div style="margin-right: 20px">
				  	<div class="custom-slider">
				  		<img src="{{ url('images/'.$service->thumnail_url) }}">
				  		<div class="m-2">
				  			<h3 class="slide-title font-15px">{{$service->title}}</h3>
				  			<label class="slide-type font-12px">TRAINING {{$service->type}}</label>
				  			<label class="slide-text font-10px">{{$service->description}}</label>
				  			<div class="align-self-baseline">
				  				<p class="float-left session-txt font-12px">For one session</p>
				  				<p class="float-right price-clss">${{ $service->price }}</p>
				  			</div>
				  		</div>
				  	</div>
				  </div>
				@endforeach
				</div>

				<div class="services">
				</div>
				<div class="gif-loader d-flex justify">
					<img src="{{ url('images/loading.gif') }}">
				</div>
				<div style="display: grid">
					<button id="view_more" style="display: none">View more</button>
					<p class="available-txt text-center">No more service request</p>
				</div>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript" src="/js/app.js"></script>
<!-- JavaScript -->
<script src="{{ url('js/alertify.js') }}"></script>
<script>
	var service = {!! $usersServices->first()->id !!}
	var service_id_arr = {!! $usersServices->pluck('id') !!}
	var count = {!! $count !!}, uri = '{!! $uri !!}'
	var limit = 2, offset = 0, is_viewmore = false;

	$(document).ready(function() {
		$('.slider-container').slick({
			dots: true,
			arrows: false
		});
		if (count > 0) {
			getBookings(service)
		} else {
			$('.gif-loader img').hide();
		}
		$('.slider-container').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
			$('.gif-loader img').show();
			offset = 0;
			service = service_id_arr[nextSlide]
			$('#view_more').hide()
			getBookingCount()
		})

		$(document).on('click', '#view_more', function() {
			$('.gif-loader img').show();
			offset = offset+limit;
			if(offset+1 == count) $('#view_more').hide()
			is_viewmore = true;
			getBookings();
		})

		$(document).on('click', '#accept_req', function() {
			id = $(this).parent().find('input[name="booking_id"]')[0].value;
			if (uri == 'bookings/request') {
				staus = 'ACTIVE'
			} else if (uri == 'bookings/service') {
				staus = 'PAYMENT'
			}
			updateStatus(id, staus)
		})
	})

	function getBookings() {
		$('.gif-loader img').show();
		$.ajax({
			url: '{{ route("get-bookings") }}',
			method: 'POST',
			data: { "_token": '{{ csrf_token() }}', "service_id": service, 'limit': limit, 'offset': offset, 'uri': uri },
			success: function(response) {
				if(is_viewmore) {
					$('.services').append(response);
				} else {
					$('.services').html(response);
					if(parseInt(count) <= limit) {
						$('#view_more').hide()
					} else {
						$('#view_more').show()
					}
				}
				$('.services').show();
				is_viewmore = false;
				$('.gif-loader img').hide();
			}
		})
	}

	function getBookingCount() {
		$.ajax({
			url: '{{ route("get-booking-count") }}',
			method: 'POST',
			data: { "_token": '{{ csrf_token() }}', "service_id": service, 'limit': limit, 'offset': offset },
			success: function(response) {
				count = response;
				$('.services').hide();
				getBookings()
			}
		})
	}

	function updateStatus(id, status) {
		$.ajax({
			url: '{{ route("update-status") }}',
			method: 'POST',
			data: { "_token": '{{ csrf_token() }}', 'id': id, 'status': status },
			success: function(response) {
				if (response.status == 'success') {
					alertify.success(response.status);;
				}
				getBookings()
			}
		})
	}
</script>
</html>