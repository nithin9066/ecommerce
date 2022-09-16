<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Redirect;

class userController extends Controller
{
    function signup(Request $request)
    {
      
        $obj = new User;
        $obj->create($request);
        return Redirect::route('index');
        
    }
    function login()
    {
        return Auth::login($user);
    }
}
