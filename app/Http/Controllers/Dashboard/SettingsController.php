<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShippingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function editShippingmethod($type){


        if($type == 'free'){

         $shipping_method =  Setting::where('key','free_shipping_label')->first();

        }elseif ($type == 'local'){

            $shipping_method =  Setting::where('key','local_shipping_label')->first();

        }elseif($type == 'outer'){
            $shipping_method = Setting::where('key','outer_shipping_label')->first();

        }else{
            $shipping_method =  Setting::where('key','free_shipping_label')->first();
        }

        return view('Dashboard.settings.shipping.edit',compact('shipping_method'));
    }

    public function updateShippingmethod(ShippingRequest $request,$id){

            //validate

        try {

            //update
            //check id
            $shipping = Setting::find($id);
            //to make if the two methods of update success not only one of them
            DB::beginTransaction();
            $shipping -> update(['plain_value' => $request->plain_value]);

            //update data on the setting_translation
            $shipping -> value = $request->value;
            $shipping -> save();
            DB::commit();
            return redirect()->back()->with(['success'=>'تم تعديل البيانات بنجاح']);

       }catch (\Exception $ex){
            DB::rollBack();
            return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات' ]);
        }


    }
}
