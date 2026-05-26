<h2>Booking Confirmed 🎉</h2>

<p>Hello {{ $booking->user->name }},</p>

<p>Your booking has been successfully confirmed.</p>

<hr>

<p><strong>Space:</strong> {{ $booking->space->title }}</p>
<p><strong>Dates:</strong> {{ $booking->start_date }} → {{ $booking->end_date }}</p>
<p><strong>Total:</strong> ₹{{ $booking->total_price }}</p>

<hr>

<p>Thank you for choosing <strong>PlaceRent</strong>.</p>
<p>We hope you have a great experience!</p>
<p>Best regards,<br>The PlaceRent Team</p>
