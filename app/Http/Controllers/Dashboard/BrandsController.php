<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandsRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BrandsController extends Controller
{
    public function index(){

       $brands = Brand::orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('Dashboard.brands.index',compact('brands'));
    }
    public function create(){

        return view('dashboard.brands.create');
    }
    public function store(BrandsRequest $request)
    {

        try {

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);


            //image
            $fileName = "";
            if ($request->has('photo')) {
                $fileName = uploadImage('brands', $request->photo);
            }

            $brand = Brand::create($request->except('_token', 'photo'));

            //insert data on the categories_translation
            $brand->name = $request->name;
            $brand->photo = $fileName;
            $brand->save();
            return redirect()->route('admin.brands.all')->with(['success' => 'تم أضافه القسم بنجاح']);

        } catch (\Exception $ex) {

            return redirect()->back()->with(['error' => 'هناك خطأ فى البيانات']);
        }
    }

    public function edit($id){

        $brand =  Brand::find($id);
        if(!$brand)
            return redirect()->route('admin.brands.all')->with(['error'=>'هناك خطأ فى البيانات' ]);

        return view('Dashboard.brands.edit',compact('brand'));
    }
    public function update(BrandsRequest $request, $id){

        //validate
        //db

        try{
            $brand = Brand::find($id);
            if(!$brand)
                return redirect()->route('admin.mainCategories.edit', $id)->with(['error'=>'هناك خطأ فى البيانات' ]);

            if($request->has('photo')){
                $fileName = uploadImage('brands', $request->photo);
                Brand::where('id',$id)->update(['photo'=>$fileName]);

            }

            if(!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $brand->update($request->except('_token','id','photo'));

            //update data on the categories_translation
            $brand -> name = $request->name;
            $brand -> save();

            return redirect()->route('admin.brands.edit',$id)->with(['success'=>'تم تحديث بيانات القسم']);
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
