@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto">

    <!-- PAGE HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold">Edit Space</h2>

        <a href="{{ route('host.spaces.index') }}" class="btn-secondary">
            ← Back
        </a>
    </div>

    <!-- UPDATE FORM -->
    <div class="card p-6">

        <form method="POST"
              action="{{ route('host.spaces.update', $space) }}"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <!-- TITLE -->
            <div class="mb-4">
                <label class="font-semibold block mb-1">Title</label>
                <input type="text"
                       name="title"
                       value="{{ $space->title }}"
                       class="input-field w-full">
            </div>

            <!-- DESCRIPTION -->
            <div class="mb-4">
                <label class="font-semibold block mb-1">Description</label>
                <textarea name="description"
                          rows="4"
                          class="input-field w-full">{{ $space->description }}</textarea>
            </div>

            <!-- PRICE -->
            <div class="mb-4">
                <label class="font-semibold block mb-1">Price</label>
                <input type="number"
                       name="price"
                       value="{{ $space->price }}"
                       class="input-field w-full">
            </div>

            <!-- ADDRESS -->
            <div class="mb-4">
                <label class="font-semibold block mb-1">Address</label>
                <input type="text"
                       name="address"
                       value="{{ $space->address }}"
                       class="input-field w-full">
            </div>

            <!-- CITY -->
            <div class="mb-4">
                <label class="font-semibold block mb-1">City</label>
                <input type="text"
                       name="city"
                       value="{{ $space->city }}"
                       class="input-field w-full">
            </div>

            <!-- COUNTRY -->
            <div class="mb-6">
                <label class="font-semibold block mb-1">Country</label>
                <input type="text"
                       name="country"
                       value="{{ $space->country }}"
                       class="input-field w-full">
            </div>
        <div class="grid grid-cols-2 gap-4 mb-4">

    <div>
        <label class="block mb-1 font-semibold">Maximum Capacity</label>
        <input type="number"
               name="capacity"
               value="{{ old('capacity', $space->capacity) }}"
               class="input"
               required>
    </div>

    <div>
        <label class="block mb-1 font-semibold">Minimum Capacity</label>
        <input type="number"
               name="min_capacity"
               value="{{ old('min_capacity', $space->min_capacity) }}"
               class="input"
               required>
    </div>

</div>
<div class="mb-4">
    <label class="block mb-2 font-semibold">Available Time Slots</label>

    <select name="available_slots[]"
            multiple
            class="w-full border rounded-lg p-3 h-40">
@php
    $selectedSlots = $space->available_slots ?? [];

    if(is_string($selectedSlots)) {
        $selectedSlots = json_decode($selectedSlots, true);
    }

    if(!is_array($selectedSlots)) {
        $selectedSlots = [];
    }
@endphp
        <option value="morning" {{ in_array('morning',$selectedSlots) ? 'selected' : '' }}>🌅 Morning</option>
        <option value="afternoon" {{ in_array('afternoon',$selectedSlots) ? 'selected' : '' }}>☀️ Afternoon</option>
        <option value="evening" {{ in_array('evening',$selectedSlots) ? 'selected' : '' }}>🌇 Evening</option>
        <option value="night" {{ in_array('night',$selectedSlots) ? 'selected' : '' }}>🌙 Night</option>
        <option value="full_day" {{ in_array('full_day',$selectedSlots) ? 'selected' : '' }}>📅 Full Day</option>

    </select>

    <p class="text-xs text-gray-500 mt-1">
        Hold CTRL to select multiple
    </p>
</div>

            <!-- UPLOAD NEW IMAGES -->
            <div class="mb-6">

                <label class="font-semibold block mb-2">Upload New Images</label>

                <input type="file"
                       name="images[]"
                       id="imageInput"
                       multiple
                       accept="image/*"
                       class="input-field w-full">

                <!-- PREVIEW AREA -->
                <div id="imagePreview" class="grid grid-cols-3 gap-3 mt-4"></div>

            </div>

            <!-- SUBMIT -->
            <button class="btn-primary w-full">
                Update Space
            </button>

        </form>

    </div>

    <!-- EXISTING IMAGES -->
    @if($space->images->count())

        <div class="card p-6 mt-8">

            <h3 class="font-semibold mb-4">Current Images</h3>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                @foreach($space->images as $image)

                    <div class="relative">

                        <img src="{{ asset('storage/'.$image->image_path) }}"
                             class="rounded-lg h-28 w-full object-cover">

                        <!-- DELETE BUTTON -->
                        <form method="POST"
                              action="{{ route('host.spaces.image.delete', $image) }}"
                              class="absolute top-1 right-1">

                            @csrf
                            @method('DELETE')

                            <button onclick="return confirm('Delete this image?')"
                                    class="bg-red-600 text-white px-2 py-1 text-xs rounded hover:bg-red-700">
                                ✕
                            </button>

                        </form>

                    </div>

                @endforeach

            </div>

        </div>

    @endif

</div>

<!-- IMAGE PREVIEW SCRIPT -->
<script>

document.getElementById('imageInput').addEventListener('change', function(event) {

    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    const files = event.target.files;

    Array.from(files).forEach(file => {

        const reader = new FileReader();

        reader.onload = function(e) {

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'rounded h-24 w-full object-cover';

            preview.appendChild(img);

        };

        reader.readAsDataURL(file);

    });

});

</script>

@endsection
