<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // use package to translate
    use Translatable;

    //package to connect to columns
    protected $with = ['translations'];

    //column translate
    protected $translatedAttributes = ['name'];

    protected $table = 'tags';

    protected $guarded = [];

    protected $hidden = ['translations'];

    public $timestamps =true;


    public function deletetrans(){
        return $this->hasMany('App\Models\TagTranslation','tag_id','id');
    }
}
