<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoryRequest;
use App\Http\Requests\SubCategoriesRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubCategoriesController extends Controller
{
    ################### CRUD SUB Category ################
    public function index(){

        $main_categories =    $categories =  Category::parent()->orderBy('id','DESC')->get();

        $categories =  Category::child()->orderBy('id','DESC')->paginate(PAGINATION_COUNT);

        return view('Dashboard.subcategories.index',compact('categories','main_categories'));
    }
    public function create(){

        $categories =    $categories =  Category::parent()->orderBy('id','DESC')->get();

        return view('Dashboard.subcategories.create',compact('categories'));

    }

    public function store(SubCategoriesRequest $request){


       try {



            //validation

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category = Category::create($request->except('_token'));

            //save translations
            $category->name = $request->name;
             $category->save();

            return redirect()->route('admin.subcategories.all')->with(['success' => 'تم ألاضافة بنجاح']);


        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->route('admin.subcategories.all')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }
    }
    public function edit($id){

        $mainCategory =  Category::orderBy('id','DESC')->find($id);
        if(!$mainCategory)
            return redirect()->route('admin.mainCategories.all')->with(['error'=>'هناك خطأ فى البيانات' ]);

        //get all main category on select box
        $categories =  Category::parent()->orderBy('id','DESC')->get();

        return view('Dashboard.subcategories.edit',compact('mainCategory','categories'));
    }

    public function update(MainCategoryRequest $request, $id){

        //validate
        //db

        try{

            $category = Category::find($id);

            if(!$category)
                return redirect()->route('admin.subcategories.edit', $id)->with(['error'=>'هناك خطأ فى البيانات' ]);

            if(!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

            $category->update($request->all());
            //update data on the categories_translation
            $category -> name = $request->name;
            $category -> save();

            return redirect()->route('admin.subcategories.edit',$id)->with(['success'=>'تم تحديث بيانات القسم']);
        }catch (\Exception $ex){

            return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات' ]);
        }

    }
    public function delete($id){

        try{
            $category = Category::find($id);
            if(!$category)
                return redirect()->route('admin.subcategories.all')->with(['error'=>'هناك خطأ فى البيانات' ]);
            $category->delete();
            return redirect()->route('admin.subcategories.all')->with(['success'=>'تم حذف القسم بنجاح' ]);
        }catch (\Exception $ex){

            return redirect()->route('admin.subcategories.all')->with(['error'=>'هناك خطأ فى البيانات' ]);
        }

    }

}
