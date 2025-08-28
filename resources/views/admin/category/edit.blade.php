@extends('admin.app')

@section('content')
<main class="page-content">
    <div class="justify-content-center">
        <div class="col-12">
            <div class="card shadow rounded-card">
                <div class="card-body bg-white p-4 rounded-card">
                    <h2 class="card-title mb-3">Edit Driver</h2>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Validation Errors --}}
                    {{-- They will show automatically from @error blocks --}}

                    {{-- Driver Edit Form --}}
                    <form method="POST" action="{{ route('driver.update', $driver->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" 
                                    value="{{ old('first_name', $driver->first_name) }}">
                                @error('first_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Last Name (Optional)</label>
                                <input type="text" name="last_name" class="form-control" 
                                    value="{{ old('last_name', $driver->last_name) }}">
                                @error('last_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" 
                                    value="{{ old('email', $driver->email) }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                          
                           <div class="mb-3 col-md-6">
    <label for="phone" >Phone</label>
    <input type="text" name="phone" id="phone" class="form-control"
        value="{{ old('phone', $driver->phone ?? '') }}"  placeholder="+44 ____ ___ ___">
    @error('phone')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
<h5>Classifications</h5>
<div class="mb-3">
    <label>
        <input type="radio" name="classification" value="operator"
            {{ old('classification', $driver->classification ?? '') == 'operator' ? 'checked' : '' }}> Operator
    </label>
    <label class="ms-3">
        <input type="radio" name="classification" value="employee"
            {{ old('classification', $driver->classification ?? '') == 'employee' ? 'checked' : '' }}> Employee
    </label>
    <label class="ms-3">
        <input type="radio" name="classification" value="technician"
            {{ old('classification', $driver->classification ?? '') == 'technician' ? 'checked' : '' }}> Technician
    </label>
    @error('classification')
        <div><small class="text-danger">{{ $message }}</small></div>
    @enderror
</div>


                        <h5>Personal Details</h5>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>Job Title</label>
                                <input type="text" name="job_title" class="form-control" 
                                    value="{{ old('job_title', $driver->driver->job_title) }}">
                                @error('job_title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control" 
                                    value="{{ old('dob', $driver->driver->dob) }}">
                                @error('dob')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control" 
                                    value="{{ old('start_date', $driver->driver->start_date) }}">
                                @error('start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control" 
                                    value="{{ old('end_date', $driver->driver->end_date) }}">
                                @error('end_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>License Number (Optional)</label>
                                <input type="text" name="license_number" class="form-control" 
                                    value="{{ old('license_number', $driver->driver->license_number) }}">
                                @error('license_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Employee No</label>
                                <input type="text" name="employee_no" class="form-control" 
                                    value="{{ old('employee_no', $driver->driver->employee_no) }}">
                                @error('employee_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Hourly Rate</label>
                                <input type="number" step="0.01" name="hourly_rate" class="form-control" 
                                    value="{{ old('hourly_rate', $driver->driver->hourly_rate) }}">
                                @error('hourly_rate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                           <div class="mb-3 col-md-6">
    <label>Password</label>
    <input type="text" name="password" id="password" class="form-control" placeholder="Enter new password to change">
    @error('password')
        <small class="text-danger">{{ $message }}</small>
    @enderror
</div>


                            <div class="mb-3">
                                <label>Address</label>
                                <textarea name="address" class="form-control">{{ old('address', $driver->driver->address) }}</textarea>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-start align-items-center gap-5">
                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                            <a href="" class="btn btn-outline-danger mt-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
