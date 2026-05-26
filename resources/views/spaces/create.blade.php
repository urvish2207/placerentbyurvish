@extends('layouts.app')

@section('content')

<div class="card max-w-xl mx-auto">

<h2 class="text-xl font-bold mb-4">Create Space</h2>

<form method="POST" action="{{ route('host.spaces.store') }}">
@csrf

<input name="title" placeholder="Title" class="input-field mb-3">
<textarea name="description" placeholder="Description" class="input-field mb-3"></textarea>

<select name="category_id" class="input-field mb-3">
@foreach($categories as $id => $name)
<option value="{{ $id }}">{{ $name }}</option>
@endforeach
</select>

<input name="price" placeholder="Price" class="input-field mb-3">
<input name="address" placeholder="Address" class="input-field mb-3">
<input name="city" placeholder="City" class="input-field mb-3">
<input name="country" placeholder="Country" class="input-field mb-3">

<button class="btn-primary w-full">Create</button>

</form>

</div>

@endsection
