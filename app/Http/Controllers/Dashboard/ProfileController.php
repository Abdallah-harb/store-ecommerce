<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequst;
use App\Http\Requests\ProfileRequest;
use App\Models\Admin;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    ##########################################
    ##########################################
    ########### edit profile #################
    ##########################################
    ##########################################
    public function editProfile(){

        $admin = Admin::find(auth()->user()->id);

        return view('Dashboard.profile.edit',compact('admin'));

    }
    public function updateProfile(ProfileRequest $request){

        //validate

        //db

        try {
            //get id of admin
            $admin =Admin::find(auth('admin')->user()->id);

            unset($request['id']);
                //update
            $admin->update($request->all());

            return redirect()->back()->with(['success'=>'تم تعديل البيانات بنجاح']);
        }catch (\Exception $ex){

            return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات' ]);
        }
    }

    public function editpassword(){
        $admin = Admin::find(auth()->user()->id);

        return view('Dashboard.profile.editpassword',compact('admin'));
    }

    public function updatpassword(PasswordRequst $request){

        //validate
        //db
        try{

            $admin =Admin::find(auth('admin')->user()->id);
            if($request->filled('password')){
                $request->merge(['password' => bcrypt($request->password)]);
            }

            unset($request['id']);
            unset($request['password_confirmation']);
            $admin->update($request->all());
            return redirect()->route('edit.profile')->with(['success'=>'تم تحديث كلمه المرور بنجاح']);
        }catch (\Exception $ex){

            return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات' ]);
        }


    }
}
