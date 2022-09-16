<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use App\Rules\currentPassword;
use Auth;

class profileController extends Controller
{
    function profile()
    {
        return view('pages.profile');
    }
    function updateProfile(Request $request)
    {
        $emails = User::where('email','!=',Auth::user()->email)->pluck('email');
        $phone = User::where('phone','!=',Auth::user()->phone)->pluck('phone');
        $request->validate([
            "email" => ['required',Rule::notIn($emails)],
            "phone" => ['required',Rule::notIn($phone)],
            "name" => 'required'
        ]);
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->save();
        return response()->json(array("status"=>"success", "msg" => "Successfully Updated"), 200);
    }

    function changePassword(Request $request)
    {
        $request->validate([
            "cpassword" => ['required', new currentPassword()],
            'password' => 'required|min:6|confirmed',
        ]);
        
        $user = User::find(Auth::user()->id);
        $user->password = \Hash::make($request->password);
        $user->save();
        return response()->json(array("status"=>"success", "msg" => "Successfully Changed Password"), 200);
        
    }
}
