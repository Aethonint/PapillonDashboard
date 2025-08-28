@extends('admin.app')

@section('content')

   <main class="page-content">
    <div class="justify-content-center">
        <div class="col-12 ">
            <div  class="card shadow rounded-card ">
                <div class="card-body bg-white p-4 rounded-card ">
                    <h2 class="card-title mb-3">Update Password</h2>
                    <p class="text-muted mb-4">Ensure your account is using a long, random password to stay secure.</p>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3 col-md-6">
                            <label for="update_password_current_password" class="form-label">Current Password</label>
                            <input id="update_password_current_password" name="current_password" type="password" class="form-control" placeholder="Enter Current Password" autocomplete="current-password">
                            @error('current_password', 'updatePassword')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="update_password_password" class="form-label">New Password</label>
                            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" placeholder="Enter New Password">
                            @error('password', 'updatePassword')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="update_password_password_confirmation" class="form-label">Confirm Password</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password"placeholder="Confirm New Password">
                            @error('password_confirmation', 'updatePassword')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary mt-3">Update</button>

                            @if (session('status') === 'password-updated')
                                <p class="text-success mb-0 ">Password Updated.</p>
                            @endif
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
