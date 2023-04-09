<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\GeneralProductsRequest;
use App\Http\Requests\ProductImagesRequest;
use App\Http\Requests\ProductPriceRequest;
use App\Http\Requests\ProductStockRequest;
use App\Models\Brand;
use App\Models\Category;
use App\models\Product;
use App\models\ProductImage;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function index(){

        $products = Product::select('id','slug','price')->paginate(PAGINATION_COUNT);

        return view('Dashboard.products.general.index',compact('products'));
    }

    public function create(){

        $data = [];
        $data['brands']     = Brand::active()->select('id')->get();
        $data['tags']       = Tag::select('id')->get();
        $data['categories'] = Category::active()->select('id')->get();

        return view('Dashboard.products.general.create',$data);

    }

    public function store(GeneralProductsRequest $request){



        try{
            //validation

            if (!$request->has('is_active'))
                $request->request->add(['is_active' => 0]);
            else
                $request->request->add(['is_active' => 1]);

           $product = Product::create([

               'brand_id'   => $request->brand_id,
               'slug'       => $request->slug,
               'is_active'  => $request->is_active,
           ]);

            //save translations
            $product->name = $request->name;
            $product->description = $request->description;
            $product->short_description = $request->short_description;
            $product->save();

            //save categories
            $product->categories()->attach($request->categories);

            //save tags
            $product->tags()->attach($request->tags);

            //save brands
            //$product->brand->$request->brand;

            return redirect()->route('admin.products.all')->with(['success' => 'تم ألاضافة بنجاح']);


        } catch (\Exception $ex) {

            return redirect()->route('admin.products.all')->with(['error' => 'حدث خطا ما برجاء المحاوله لاحقا']);
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
