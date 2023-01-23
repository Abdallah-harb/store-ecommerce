<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
// use package to translate
    use Translatable;

    //package to connect to columns
    protected $with = ['translations'];

    //column translate
    protected $translatedAttributes = ['name'];

    protected $table = 'brands';

    protected $guarded = [];

    protected $hidden = ['translations'];

    //make the value of is_translatble from [0 , 1 ] => to [true , false ] when I return it
    protected $casts = ['is_active' => 'boolean'];

    public $timestamps =true;

    public function getActive(){

        return $this->is_active == 0?'غير مفعل':'مفعل';
    }

    public function getPhotoAttribute($val){

        return ($val !== null)? asset('assets/images/brands/' .$val) :"";
    }

}
