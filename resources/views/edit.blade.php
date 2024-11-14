@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center"><h1 class="fw-bold">Edit Contact</h1></div>

                <div class="card-body bg-white py-3">
                    <form method="POST" action="{{ route('contacts.update', $contact->id) }}">
                        @csrf
                        @method('PUT') <!-- Indicating this is a PUT request for updating -->

                        <!-- Name Field -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $contact->name) }}" required>
                        </div>

                        <!-- Company Field -->
                        <div class="mb-3">
                            <label for="company" class="form-label">Company</label>
                            <input type="text" class="form-control" id="company" name="company" value="{{ old('company', $contact->company) }}" required>
                        </div>

                        <!-- Phone Field -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $contact->phone) }}" required>
                        </div>

                        <!-- Email Field -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $contact->email) }}" required>
                        </div>

                        <!-- Submit Button -->
                        <a href="/home" id="addContactButton" class="btn btn-danger mr-2">Cancel</a>
                        <button type="submit" class="btn btn-success">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection