<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\models\Product;

class CategoryController extends Controller
{
        //when category sector and product inside it
    public function productBySlug($slug){

        $data = [];
        $data['category'] = Category::where('slug',$slug)->first();
        if ($data['category'])
              $data['products'] = $data['category']->products;
        //return Product::find(1)->images[0];
        return view('Front.products.all',$data);
    }



}
