<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;

class HomeController extends Controller
{

    public function home(){

        //show images sliders
        $data = [];
        $data['images'] = Slider::latest()->take(3)->get(['photo']);
        //show categories and childrens
        $data['categories'] = Category::parent()->select('id','slug')->with(['childerens'=>function($q){
            $q->select('id','parent_id','slug');
            $q->with(['childerens'=> function($qq){
                $qq->select('id','parent_id','slug');
            }]);
        }])->orderBy('id','DESC')->get();
        return view('Front.home',$data);
    }



}
