<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    // use package to translate
    use Translatable;

    //package to connect to columns
    protected $with = ['translations'];

    //column translate
    protected $translatedAttributes = ['name'];

    protected $table = 'product_attributes';

    protected $guarded = [];

    protected $hidden = ['translations'];

    public $timestamps =true;

        //relation
    public function options(){

        return $this->hasMany(Option::class,'attribute_id');
    }


}
