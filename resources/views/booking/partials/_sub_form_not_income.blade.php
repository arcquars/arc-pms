<?php
use App\Models\Booking;
/** @var Booking $booking */
?>
<div class="form-group">
    <label for="c-booking-comments">Observaciones</label>
    <textarea class="form-control form-control-sm" id="c-booking-comments" name="booking[comments]" >{{ $booking->comments }}</textarea>
    <div class="invalid-feedback"></div>
</div>
