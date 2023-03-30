<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
            //validation;

           $option = Option::create([

               'product_id'      => $request->product_id,
               'attribute_id'    => $request->attribute_id,
               'price'           => $request->price,
           ]);

            //save translations
            $option->name = $request->name;
            $option->save();

            return redirect()->route('admin.options.all')->with(['success' => 'تم ألاضافة بنجاح']);


        } catch (\Exception $ex) {

            return redirect()->route('admin.options.all')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
        }

    }
        #######################################################
        #######################################################
        ################### prices ############################
        #######################################################
        #######################################################

    public  function getPrice($product_id){


        return view('Dashboard.products.prices.create')->with('id',$product_id);

    }
    public function storePrice(ProductPriceRequest $request){

        try {

            Product::whereId($request->product_id)->update($request->only(['price','special_price','special_price_type','special_price_start','special_price_end']));
            return redirect()->route('admin.products.all')->with(['success' => 'تم ألاضافة بنجاح']);

        }catch (\Exception $ex){

            return redirect()->route('admin.products.all')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }

    }

    #######################################################
    #######################################################
    ################### Inventory #########################
    #######################################################
    #######################################################

    public  function getStock($product_id){


        return view('Dashboard.products.stock.create')->with('id',$product_id);

    }
    public function storeStock(ProductStockRequest $request){


        try {

            Product::whereId($request->product_id)->update($request->only(['sku','manage_stock','in_stock','qty']));
            return redirect()->route('admin.products.all')->with(['success' => 'تم ألاضافة بنجاح']);

        }catch (\Exception $ex){

            return redirect()->route('admin.products.all')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }

    }

        #######################################################
        #######################################################
        ################### Images    #########################
        #######################################################
        #######################################################

    public function getImage($product_id){

        return view('Dashboard.products.images.create')->with('id',$product_id);

    }

            //store on products folder

    public function storeimage(Request $request){

        $file = $request->file('dzfile');
        $filename = uploadImage('products', $file);

        return response()->json([
            'name' => $filename,
            'original_name' => $file->getClientOriginalName(),
        ]);

    }

        //store images on db

    public function saveimagedb(ProductImagesRequest $request){

        try {
                // save dropzone images
                if ($request->has('document') && count($request->document) > 0) {
                    foreach ($request->document as $image) {
                        ProductImage::create([
                            'product_id' => $request->product_id,
                            'photo' => $image,
                        ]);
                    }
                }

            return redirect()->route('admin.products.all')->with(['success' => 'تم التحديث بنجاح']);

        }catch(\Exception $ex){

            return redirect()->route('admin.products.all')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);

        }

    }



}
