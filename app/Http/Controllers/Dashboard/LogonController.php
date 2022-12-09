<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\Request;

class LogonController extends Controller
{
    // function to show login form with blade file
    public function login(){

        return view('Dashboard.auth.login');
    }

    //to login
    public function postlogin( AdminLoginRequest $request){

        //validation  [ AdminLoginRequest ]
        //check if the admin exist on database [by guard ]

        $remember_me = $request->has('remember_me')?true:false;

        if(auth()->guard('admin')->attempt(['email' => $request->input('email'),'password' =>$request->input('password')],$remember_me)){

            return redirect()->route('admin.dashboard');
        }else{

            return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات']);
        }
    }

    //logout
    public function logout(){

        auth('admin')->logout();
        return redirect()->route('admin.login');
    }
}
