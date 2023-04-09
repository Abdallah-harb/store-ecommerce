<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SlidersController extends Controller
{

    public function getImage(){
        $images= Slider::get('photo');
        return view('Dashboard.sliders.create',compact('images'));
    }

            //store on products folder

    public function storeimage(Request $request){

        $file = $request->file('dzfile');
        $filename = uploadImage('sliders', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);

    }

        //store images on db

    public function saveimagedb(SliderRequest $request){

        try {
                // save dropzone images
                if ($request->has('document') && count($request->document) > 0) {
                    foreach ($request->document as $image) {
                        Slider::create([
                            'photo' => $image,
                        ]);
                    }
                }

            return redirect()->route('admin.slide.create')->with(['success' => 'تم التحديث بنجاح']);

        }catch(\Exception $ex){

            return redirect()->route('admin.slide.create')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }

    }



}
