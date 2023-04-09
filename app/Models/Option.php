<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
// use package to translate
    use Translatable;

    //package to connect to columns
    protected $with = ['translations'];

    //column translate
    protected $translatedAttributes = ['name'];

    protected $table = 'options';

    protected $guarded = [];

  //  protected $hidden = ['translations'];

    public $timestamps =true;

            //relations

    public function product(){

        return $this->belongsTo(Product::class,'product_id','id');
    }
    public function attribute(){

        return $this->belongsTo(Attribute::class,'attribute_id');
    }

}
