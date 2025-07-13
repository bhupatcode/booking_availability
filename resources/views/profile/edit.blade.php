@extends('layouts.app')

@section('content')
<div class="container">
        @include('components.back-button') <!-- ✅ Back Button -->
    <h2 class="mb-4 fw-semibold text-primary"><i class="bi bi-person-circle me-2"></i>Manage Your Profile</h2>

    {{-- Update Profile Info --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="bi bi-info-circle me-2"></i> Update Profile Information
        </div>
        <div class="card-body">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Update Password --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-warning text-dark fw-semibold">
            <i class="bi bi-lock-fill me-2"></i> Update Password
        </div>
        <div class="card-body">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Delete Account --}}
    <div class="card shadow-sm border-danger">
        <div class="card-header bg-danger text-white fw-semibold">
            <i class="bi bi-trash3 me-2"></i> Delete Account
        </div>
        <div class="card-body">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>
@endsection
