@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 px-md-5">
    <div class="page-inner">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h3 class="mt-5 mb-2 fw-bold">User Information</h3>
            </div>
        </div>

        {{-- Baris pertama: dua card (responsif) --}}
        <div class="row">
            <!-- Update Profile Information -->
            <div class="col-12 col-lg-6 mb-4">
                <div class="card shadow-sm rounded h-100">
                    <div class="card-body p-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <!-- Update Password -->
            <div class="col-12 col-lg-6 mb-4">
                <div class="card shadow-sm rounded h-100">
                    <div class="card-body p-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>

        {{-- Baris kedua: delete user --}}
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card shadow-sm rounded">
                    <div class="card-body p-4">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
