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

    //make the value of is_translatble from [0 , 1 ] => to [true , false ] when I return it
    protected $casts = ['is_active' => 'boolean'];

    public $timestamps =true;
}
