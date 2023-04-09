<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttributesRequest;
use App\Http\Requests\BrandsRequest;
use App\Models\Attribute;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class AttributesController extends Controller
{
    public function index(){

       $attributes = Attribute::orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('Dashboard.attributes.index',compact('attributes'));
    }
    public function create(){

        return view('dashboard.attributes.create');
    }
    public function store(AttributesRequest $request)
    {

        try {

            $attribute = Attribute::create([]);

            //insert data on the categories_translation
            $attribute->name = $request->name;
            $attribute->save();
            return redirect()->route('admin.attributes.all')->with(['success' => 'تم أضافه القسم بنجاح']);

        } catch (\Exception $ex) {

            return redirect()->back()->with(['error' => 'هناك خطأ فى البيانات']);
        }
    }

    public function edit($id){

        $attribute =  Attribute::find($id);
        if(!$attribute)
            return redirect()->route('admin.attributes.all')->with(['error'=>'هناك خطأ فى البيانات' ]);

        return view('Dashboard.attributes.edit',compact('attribute'));
    }

    public function update(AttributesRequest $request, $id){

        //validate
        //db

        try{
            $brand = Brand::find($id);
            if(!$brand)
                return redirect()->route('admin.mainCategories.edit', $id)->with(['error'=>'هناك خطأ فى البيانات' ]);



            $brand->update($request->except('_token','id'));

            //update data on the categories_translation
            $brand -> name = $request->name;
            $brand -> save();

            return redirect()->route('admin.attributes.edit',$id)->with(['success'=>'تم تحديث بيانات ']);
        }catch (\Exception $ex){

            return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات' ]);
        }

    }

    public function delete($id){

        try{
            $brand =  Brand::find($id);
            $image_path         = public_path("\public\assets\images\brands\\") .$brand->photo;
            if(!$brand)
                return redirect()->route('admin.brands.all')->with(['error'=>'هناك خطأ فى البيانات' ]);

            if(File::exists($image_path)) {
                File::delete($image_path);
            }

            $brand->delete();

            return redirect()->route('admin.brands.all')->with(['success'=>'تم حذف القسم بنجاح' ]);
        }catch (\Exception $ex){

            return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات' ]);
        }

    }
}
