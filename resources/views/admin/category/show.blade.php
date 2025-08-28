@extends('admin.app')

@section('content')
<style>
    
</style>
<main class="page-content">
    <div class="justify-content-center">
        <div class="col-12">
            <div class="card shadow rounded-card">
                <div class="card-body bg-white p-4 rounded-card">

                    <!-- Page Title -->
                    <h2 class="card-title mb-3">Driver Detail</h2>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <!-- Driver Details Box -->
                    <div class="  p-3 rounded  drivers-details" >
                        
                        <!-- Section Heading -->
                        <h5 class=" driver-information fw-bold mb-3">Driver Information</h5>
                    <p class="p-border"></p>
                        <div class="row mb-2">
                            <div class="col-md-6">
                                <strong>Full Name:</strong> {{ $driver->first_name }} {{ $driver->last_name }}
                            </div>
                            <div class="col-md-6">
                                <strong>Employee No:</strong> {{ $driver->driver->employee_no ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <strong>Email:</strong> {{ $driver->email }}
                            </div>
                            <div class="col-md-6">
                                <strong>Phone:</strong> {{ $driver->phone }}
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <strong>Job Title:</strong> {{ $driver->driver->job_title ?? 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Classification:</strong> {{ $driver->classification ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <strong>Date of Birth:</strong> {{ $driver->driver->dob ?? 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <strong>Hourly Rate:</strong> £{{ number_format($driver->driver->hourly_rate ?? 0, 2) }}
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <strong>Start Date:</strong> {{ $driver->driver->start_date ?? 'N/A' }}
                            </div>
                            <div class="col-md-6">
                                <strong>End Date:</strong> {{ $driver->driver->end_date ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-6">
                                <strong>Address:</strong> {{ $driver->driver->address ?? 'N/A' }}
                            </div>
                             <div class="col-md-6">
                                <strong>Lisence No:</strong> {{ $driver->driver->license_number ?? 'N/A' }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <strong>Notes:</strong> {{ $driver->driver->notes ?? 'N/A' }}
                            </div>
                        </div>

                    </div><!-- End Box -->
  <div class="mt-3">
                        <a href="{{ route('driver.index') }}" class="btn btn-primary">Back to Drivers</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
