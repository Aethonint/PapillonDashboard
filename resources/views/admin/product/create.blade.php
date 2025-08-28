@extends('admin.app')

@section('content')
<main class="page-content">
    <div class="justify-content-center">
        <div class="col-12">
            <div class="card shadow rounded-card">
                <div class="card-body bg-white p-4 rounded-card">
                    <h2 class="card-title mb-3">Drivers</h2>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Validation Errors --}}
                   

                    {{-- Driver Create Form --}}
                    <form method="POST" action="">
                        @csrf

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>First Name</label>
                                <input type="text" name="first_name" class="form-control" 
                                    placeholder="Enter first name" value="{{ old('first_name') }}">
                                @error('first_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Last Name (Optional)</label>
                                <input type="text" name="last_name" class="form-control" 
                                    placeholder="Enter last name" value="{{ old('last_name') }}">
                                @error('last_name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" 
                                    placeholder="Enter email address" value="{{ old('email') }}">
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                           <div class="mb-3 col-md-6">
    <label for="phone" >Phone</label>
    <input type="text" name="phone" id="phone" class="form-control"
        value="{{ old('phone', $user->phone ?? '') }}"  placeholder="+44 ____ ___ ___">
    @error('phone')
        <div class="text-danger">{{ $message }}</div>
    @enderror
</div>
                        </div>

                        <h5 class="card-subtitle mb-2">Classifications</h5>
                        <div class="mb-3">
                            <label>
                                <input type="radio" name="classification" value="operator" {{ old('classification') == 'operator' ? 'checked' : '' }}> Operator
                            </label>
                            <label class="ms-3">
                                <input type="radio" name="classification" value="employee" {{ old('classification') == 'employee' ? 'checked' : '' }}> Employee
                            </label>
                            <label class="ms-3">
                                <input type="radio" name="classification" value="technician" {{ old('classification') == 'technician' ? 'checked' : '' }}> Technician
                            </label>
                            @error('classification')
                                <div><small class="text-danger">{{ $message }}</small></div>
                            @enderror
                        </div>

                        <h5 class="card-subtitle mb-2">Personal Details</h5>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>Job Title</label>
                                <input type="text" name="job_title" class="form-control" 
                                    placeholder="Enter job title" value="{{ old('job_title') }}">
                                @error('job_title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Date of Birth</label>
                                <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
                                @error('dob')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Start Date</label>
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                                @error('start_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>End Date</label>
                                <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}">
                                @error('end_date')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>License Number (Optional)</label>
                                <input type="text" name="license_number" class="form-control" 
                                    placeholder="Enter license number" value="{{ old('license_number') }}">
                                @error('license_number')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Employee No</label>
                                <input type="text" name="employee_no" class="form-control" 
                                    placeholder="Enter employee number" value="{{ old('employee_no') }}">
                                @error('employee_no')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Hourly Rate</label>
                                <input type="number" step="0.01" name="hourly_rate" class="form-control" 
                                    placeholder="Enter hourly rate" value="{{ old('hourly_rate') }}">
                                @error('hourly_rate')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3 col-md-6">
                                <label>Password</label>
                                <input type="text" name="password" id="password" class="form-control" readonly 
                                    placeholder="Auto-generated password" value="{{ old('password') }}">
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label>Address</label>
                                <textarea name="address" class="form-control" placeholder="Enter address">{{ old('address') }}</textarea>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-start align-items-center gap-5">
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                            <a href="{{route('vehicle.index')}}" class="btn btn-outline-danger mt-3">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
