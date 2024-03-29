<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainCategoriesController extends Controller
{

    ################### CRUD Category ################
    public function index(){

      $categories =  Category::with('_parent')->orderBy('id','DESC')->paginate(PAGINATION_COUNT);

       return view('Dashboard.categories.index',compact('categories'));
    }

    public function create(){

        $categories =   Category::select('id','parent_id')->get();
        return view('Dashboard.categories.create',compact('categories'));
    }

    public function store(MainCategoryRequest $request){


        //try{

            if(!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            //if user choose main category then we must remove paret id from the request

            if($request -> type == 1) //main category
            {
                $request->request->add(['parent_id' => null]);
            }

            $category =   Category::create($request->except('_token','type'));

            //insert data on the categories_translation
              $category -> name = $request->name;
             $category -> save();
            return redirect()->route('admin.mainCategories.all')->with(['success' => 'تم أضافه القسم بنجاح']);

       // }catch (\Exception $ex){
      //  DB::rollBack();
          return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات' ]);
      // }
    }

    public function edit($id){

        $mainCategory =  Category::orderBy('id','DESC')->find($id);
        if(!$mainCategory)
            return redirect()->route('admin.mainCategories.all')->with(['error'=>'هناك خطأ فى البيانات' ]);

        return view('Dashboard.categories.edit',compact('mainCategory'));
    }

    public function update(MainCategoryRequest $request, $id){

        //validate
        //db

        try{
            $category = Category::find($id);
            if(!$category)
                return redirect()->route('admin.mainCategories.edit', $id)->with(['error'=>'هناك خطأ فى البيانات' ]);

            if(!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category->update($request->all());
            //update data on the categories_translation
            $category -> name = $request->name;
            $category -> save();

            return redirect()->route('admin.mainCategories.edit',$id)->with(['success'=>'تم تحديث بيانات القسم']);
       }catch (\Exception $ex){

            return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات' ]);
        }

    }
    public function delete($id){

        try{
                 $category = Category::find($id);
                 if(!$category)
                     return redirect()->route('admin.mainCategories.all')->with(['error'=>'هناك خطأ فى البيانات' ]);
                 $category->delete();
                return redirect()->route('admin.mainCategories.all')->with(['success'=>'تم حذف القسم بنجاح' ]);
        }catch (\Exception $ex){

                return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات' ]);
        }

    }


}
