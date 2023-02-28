<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagsRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagsController extends Controller
{
    public function index(){

       $tags = Tag::orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('Dashboard.tags.index',compact('tags'));
    }
    public function create(){

        return view('dashboard.tags.create');
    }
    public function store(TagsRequest $request)
    {

        try {

            $brand = Tag::create(['slug' => $request->slug]);

            //insert data on the categories_translation
            $brand->name = $request->name;;
            $brand->save();
            return redirect()->route('admin.tags.all')->with(['success' => 'تم أضافه tags بنجاح']);

       } catch (\Exception $ex) {

            return redirect()->back()->with(['error' => 'هناك خطأ فى البيانات']);
        }

    }

    public function edit($id){

        $tag =  Tag::find($id);
        if(!$tag)
            return redirect()->route('admin.tags.all')->with(['error'=>'هناك خطأ فى البيانات' ]);

        return view('Dashboard.tags.edit',compact('tag'));
    }

    public function update(TagsRequest $request, $id){

        //validate
        //db

        try{
            $tag = Tag::find($id);
            if(!$tag)
                return redirect()->route('admin.tags.edit', $id)->with(['error'=>'هناك خطأ فى البيانات' ]);


            $tag->update($request->except('_token','id'));

            //update data on the categories_translation
            $tag -> name = $request->name;
            $tag -> save();

            return redirect()->route('admin.tags.edit',$id)->with(['success'=>'تم تحديث بيانات القسم']);
        }catch (\Exception $ex){

            return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات' ]);
        }

    }

    public function delete($id){

        try{
            $tag =  Tag::find($id);
            if(!$tag)
                return redirect()->route('admin.tags.all')->with(['error'=>'هناك خطأ فى البيانات' ]);

            $tag->deletetrans()->delete();

            $tag->delete();

            return redirect()->route('admin.tags.all')->with(['success'=>'تم حذف القسم بنجاح' ]);
        }catch (\Exception $ex){

            return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات' ]);
        }

    }
}
