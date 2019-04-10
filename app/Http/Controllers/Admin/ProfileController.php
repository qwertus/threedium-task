<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;

class ProfileController extends Controller
{
	public function edit() {
		
		$loggedInUser = \Auth::user();
		
		return view('profile.edit', [
			'user' => $loggedInUser
		]);
	}
	
	public function update() {
		
		$loggedInUser = \Auth::user();
		
		$request = request();
		
		$formData = $request->validate([
			'name' => 'required|string|min:3',
			'email' => 'required|email|unique:users,email,' . $loggedInUser->id
                        
		]);
		
		$loggedInUser->fill($formData);
		$loggedInUser->save();
		
		return redirect()->back()
				->with('systemMessage', 'Successfully updated your profile!');
	}
	
	public function changePassword() {
            
                $loggedInUser = \Auth::user();
		
		return view('profile.change-password', [
			'user' => $loggedInUser
		]);
	}
	
	public function updatePassword() {
		$loggedInUser = \Auth::user();
		
		$request = request();
		
		$formData = $request->validate([
			'old_password' => 'required|string',
			'password' => 'required|string|min:7',
			'password_confirmation' => 'required|same:password'
		]);
		
		$loggedInUser->fresh();
		
		if(!\Hash::check($formData['old_password'], $loggedInUser->password)) {
			return redirect()->back()
					->with('systemError', 'Old password does not match!');
		}
		
		$loggedInUser->password = bcrypt($formData['password']);
		$loggedInUser->save();
		
		return redirect()->back()
				->with('systemMessage', 'Password successfully changed!');
	}
}
