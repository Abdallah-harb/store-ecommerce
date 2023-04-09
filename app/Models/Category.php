<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // use package to translate
    use Translatable;

    //package to connect to columns
    protected $with = ['translations'];

    //column translate
    protected $translatedAttributes = ['name'];

    protected $table = 'categories';

    protected $guarded = [];

    protected $hidden = ['translations'];

    //make the value of is_translatble from [0 , 1 ] => to [true , false ] when I return it
    protected $casts = ['is_active' => 'boolean'];

    public $timestamps =true;

    ######################## function helper to controller ##############################

    public function scopeParent($query){
        return $query->whereNull('parent_id');
    }

    public function scopeActive($query){

        return $query->where('is_active',1);
    }

    public function getActive(){

        return $this->is_active == 0?'غير مفعل':'مفعل';
    }

    public function scopeChild($query){
        return $query->whereNotNull('parent_id');
    }
        //relation to get name of main category for subcategory
    public function _parent(){

        return $this->belongsTo(self::class,'parent_id');
    }




        // this relation used on frontend to show childrens of category and childrens of subcategory
    public function childerens(){

        return $this->hasMany(self::class,'parent_id');
    }

        // this relation used on frontend to show product of category
    public function products(){
        return $this->belongsToMany(Product::class,'product_categories','category_id','product_id','id','id');
    }
}
