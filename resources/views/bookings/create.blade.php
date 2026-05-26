@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
<div class="card max-w-md mx-auto">

    <h2 class="text-xl font-bold mb-4">Book Space</h2>

    <p class="mb-3">{{ $space->title }} — ₹{{ $space->price }}/day</p>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('bookings.store',$space) }}">
        @csrf

        <!-- RANGE CALENDAR -->
        <label class="block mb-2 font-semibold">Select Dates</label>

        <input type="text"
               id="date_range"
               class="input-field mb-4"
               placeholder="Select booking dates"
               required>

        <!-- HIDDEN FIELDS -->
        <input type="hidden" name="start_date" id="start_date">
        <input type="hidden" name="end_date" id="end_date">
<div class="flex items-center gap-4 mb-4 text-sm">

    <div class="flex items-center gap-1">
        <span class="w-4 h-4 bg-red-400 rounded"></span>
        <span>Booked</span>
    </div>

    <div class="flex items-center gap-1">
        <span class="w-4 h-4 bg-green-400 rounded"></span>
        <span>Available</span>
    </div>

</div>
        <!-- PEOPLE -->
        <div class="mb-4">
            <label class="block mb-1">Number of People</label>

            <input type="number"
                   name="people_count"
                   min="{{ $space->min_capacity }}"
                   max="{{ $space->capacity }}"
                   class="input-field"
                   required>
        </div>

        <!-- SLOT -->
        <div class="mb-4">
            <label class="block mb-1">Select Time Slot</label>

            @php
                $slots = $space->available_slots ?? ['full_day'];
            @endphp

            <select name="time_slot" class="input-field" required>
                @foreach($slots as $slot)
                    <option value="{{ $slot }}">
                        {{ ucfirst(str_replace('_',' ', $slot)) }}
                    </option>
                @endforeach
            </select>
        </div>
<!-- PRICE PREVIEW -->
<div id="priceBox"
     class="hidden mb-4 p-4 rounded-xl bg-indigo-50 text-indigo-700">

    <p id="daysText"></p>
    <p class="font-bold text-lg" id="totalPrice"></p>

</div>
        <button class="btn-primary w-full">
            Confirm Booking
        </button>

    </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    console.log("Flatpickr loaded");

    let disabledDates = @json($disabledDates);
    let pricePerDay = {{ $space->price }};

    flatpickr("#date_range", {
        mode: "range",
        minDate: "today",
        disable: disabledDates,
        dateFormat: "Y-m-d",
        theme: "material_blue",

        onChange: function(selectedDates) {

            if (selectedDates.length === 2) {

                let start = selectedDates[0];
                let end = selectedDates[1];

                document.getElementById('start_date').value =
                    flatpickr.formatDate(start, "Y-m-d");

                document.getElementById('end_date').value =
                    flatpickr.formatDate(end, "Y-m-d");

                let diffTime = end - start;
                let days = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;

                let total = days * pricePerDay;

                document.getElementById('priceBox').classList.remove('hidden');

                document.getElementById('daysText').innerText =
                    days + " days × ₹" + pricePerDay;

                document.getElementById('totalPrice').innerText =
                    "Total: ₹" + total;
            }
        }
    });
</script>   

@endsection