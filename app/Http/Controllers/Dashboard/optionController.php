<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandsRequest;
use App\Http\Requests\GeneralProductsRequest;
use App\Http\Requests\OptionsRequest;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Requests\ProductPriceRequest;
use App\Http\Requests\ProductStockRequest;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Option;
use App\models\Product;
use App\models\ProductImage;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class optionController extends Controller
{
    public function index(){

         $options = Option::with([
                        'product'=>function($q){
                                               $q->select('id');
                                           },
                        'attribute'=>function($q){
                                               $q->select('id');
                         }])->select('id','product_id','attribute_id','price')->paginate(PAGINATION_COUNT);

        return view('Dashboard.options.index',compact('options'));
    }

    public function create(){

        $data = [];
        $data['products']     = Product::active()->select('id')->get();
        $data['attributes']       = Attribute::select('id')->get();

        return view('Dashboard.options.create',$data);

    }

    public function store(OptionsRequest $request){

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

    public function edit($id){

        $data = [];
        $data['option'] = Option::find($id);
        if(!$data['option'])
            return redirect()->route('admin.options.all')->with(['error'=>'هناك خطأ فى البيانات' ]);

        $data['products']     = Product::active()->select('id')->get();
        $data['attributes']       = Attribute::select('id')->get();

        return view('Dashboard.options.edit',$data);
    }

    public function update(OptionsRequest $request, $id){

        //validate
        //db

        try{
            $option = Option::find($id);
            if(!$option)
                return redirect()->route('admin.mainCategories.edit', $id)->with(['error'=>'هناك خطأ فى البيانات' ]);

            $option->update($request->except('_token','id'));

            //update data on the categories_translation
            $option -> name = $request->name;
            $option -> save();

            return redirect()->route('admin.options.edit',$id)->with(['success'=>'تم تحديث بيانات القسم']);
        }catch (\Exception $ex){

            return redirect()->back()->with(['error'=>'هناك خطأ فى البيانات' ]);
        }

    }



}
