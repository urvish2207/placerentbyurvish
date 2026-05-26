@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto">

    <h2 class="text-2xl font-bold mb-6">Create New Space</h2>

    <div class="card p-6">

      <form method="POST" action="{{ route('host.spaces.store') }}" enctype="multipart/form-data">

            @csrf

            <div class="mb-4">
                <label class="label">Title</label>
                <input type="text" name="title" class="input-field w-full">
            </div>

            <div class="mb-4">
                <label class="label">Description</label>
                <textarea name="description" class="input-field w-full"></textarea>
            </div>

            <div class="mb-4">
                <label class="label">Category</label>
                <select name="category_id" class="input-field w-full">
                    @foreach($categories as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="label">Price</label>
                <input type="number" name="price" class="input-field w-full">
            </div>

            <div class="mb-4">
                <label class="label">Address</label>
                <input type="text" name="address" class="input-field w-full">
            </div>

            <div class="mb-4">
                <label class="label">City</label>
                <input type="text" name="city" class="input-field w-full">
            </div>

            <div class="mb-6">
                <label class="label">Country</label>
                <input type="text" name="country" class="input-field w-full">
            </div>
            <input type="number" name="capacity" placeholder="Max Capacity" class="input mb-3">

<input type="number" name="min_capacity" placeholder="Minimum Booking Capacity" class="input mb-3">
<div class="mb-4">
    <label class="block mb-2 font-semibold">Available Time Slots</label>

    <select name="available_slots[]"
            multiple
            class="w-full border rounded-lg p-3 h-40">

        <option value="morning">🌅 Morning</option>
        <option value="afternoon">☀️ Afternoon</option>
        <option value="evening">🌇 Evening</option>
        <option value="night">🌙 Night</option>
        <option value="full_day">📅 Full Day</option>

    </select>

    <p class="text-xs text-gray-500 mt-1">
        Hold CTRL (Windows) or CMD (Mac) to select multiple
    </p>
</div>
        <div class="mb-4">
    <label class="label">Upload Images</label>
    <input type="file" name="images[]" multiple class="input-field w-full">
</div>

            <button class="btn-primary w-full">
                Create Space
            </button>

        </form>

    </div>

</div>

@endsection
