@extends('layouts.app')

@section('header')
<h2 class="fw-semibold text-xl text-dark-emphasis">
    {{ __('Profile') }}
</h2>
@endsection

@section('content')
<div class="py-5">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-md-6">
                <div class="p-4 bg-white border rounded shadow-sm">
                    <header>
                        <h2 class="h4 text-dark">
                            {{ __('Profile Information') }}
                        </h2>
                        <p class="text-muted">
                            {{ __("Update your account's profile information and email address.") }}
                        </p>
                    </header>
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-4 bg-white border rounded shadow-sm">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-4 bg-white border rounded shadow-sm">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="col-md-6">
                <div class="p-4 bg-white border rounded shadow-sm">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
    @endsection