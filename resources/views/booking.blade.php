@foreach($bookings as $booking)
	<div class="maindata-container">
		<div class="row">
			<div class="col-5">
				<span class="status-label">Pending Request</span><br />
				<label>{{ Carbon\Carbon::parse($booking->created_at)->format('H:i A, d/m/Y') }}</label>
			</div>
			<div class="col-7 bar-design d-flex justify-content-center">
				<div class="rnd-textwrap request-clss font-twelvepix"><p class="rounded-text">1</p></div>
				<span></span>
				<div class="rnd-textwrap service-clss font-twelvepix"><p class="rounded-text">2</p></div>
				<span></span>
				<div class="rnd-textwrap payment-clss font-twelvepix"><p class="rounded-text">3</p></div>
			</div>
		</div>
		<div class="row user-section">
			<div class="col-6" style="display: inline-flex;">
				<img class="avatar" src="{{ url('images/'.$booking->user->avatar) }}">
				<div class="ml-2 m-auto">
					<p class="nname font-12px">{{ $booking->user->name }}</p>
					<label class="pplace font-10px">{{ $booking->user->city }}</label>
				</div>
			</div>
			<div class="col-6 d-inline-flex justify-content-center my-auto">
				<img class="my-auto handshake" src="https://img.pngio.com/handshakeiconpng-png-handshake-1459_1067.png">
				<p class="deal-tag font-12px">You two had 12 deals before.</p>
			</div>
		</div>
		<p class="col-12 available-txt">This customer is available at:</p>
		<div class="row">
			<div class="col-1">
				<i class="font-icon-common fa fa-clock-o"></i>
			</div>
			<div class="col-10 font-weight-bold">
				<table class="table-borderless">
					<tbody>
						@foreach($booking->slot as $slot)
						<tr>
							<td class="tablecell-one">{{ $slot->getBookingSlotDateAttribute() }}</td>
							<td>{{ $slot->slot_timing }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-1">
				<i class="font-icon-common fa fa-map-marker"></i>
			</div>
			<div class="col-10">
				<p class="nname font-12px">{{ $booking->address }}</p>
			</div>
		</div>
		<div class="row d-flex justify-content-center">
			<button class="btn btn-outline-primary mr-lg-4 mr-md-3 mr-2" id="reshedule">Reschedule</button>
			<button class="btn btn-primary mr-lg-4 mr-md-3 mr-2" id="accept_req">Accept Request</button>
			<input type="hidden" name="booking_id" value="{{ $booking->id }}">
			<div class="my-auto moresec-clss">
				<a href="#">
					<span class="d-flex justify-content-center">
						<i class="fa fa-ellipsis-h"></i><br />
					</span>
					<span>More</span>
				</a>
			</div>
		</div>
	</div>
@endforeach