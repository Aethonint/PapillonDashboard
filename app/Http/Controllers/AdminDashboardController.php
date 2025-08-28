<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
   public function index()
   {
    return view('admin.dashboard');
   }
   public function logout(Request $request)
   {
     Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
   }
   public function adminprofile()
   {
      $user=Auth::user();
      return view('profile.partials.update-profile-information-form',compact('user'));
   }
   public function changepassword()
   {
      $user=Auth::user();
      return view('profile.partials.update-password-form',compact('user'));
   }
   public function dashboard()
   {
      return view('admin.dashboard');
   }
}
