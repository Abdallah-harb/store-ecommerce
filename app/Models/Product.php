<?php

namespace App\models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    // use package to translate
    use Translatable,
        SoftDeletes;

    //package to connect to columns
    protected $with = ['translations'];

    //column translate
    protected $translatedAttributes = ['name','description','short_description'];

    protected $table = 'products';

    protected $guarded = [];

    protected $hidden = ['translations'];

    //make the value of is_translatble from [0 , 1 ] => to [true , false ] when I return it
    protected $casts = [
                        'is_active'    => 'boolean',
                        'manage_stock' => 'boolean',
                        'in_stock'     => 'boolean'];

    //data that returned with date

    protected $dates = ['special_price_start','special_price_end','start_date','end_date','deleted_at'];

    public $timestamps =true;


    public function getActive(){

        return $this->is_active == 0?'غير مفعل':'مفعل';
    }

    public function scopeActive($query){

        return $query->where('is_active',1);
    }


    //relations

    public function brand(){
        return $this->belongsTo(Brand::class)->withDefault();
    }

    public function categories(){

        return $this->belongsToMany(Category::class,'product_categories');
    }

    public function tags(){

        return $this->belongsToMany(Tag::class,'product_tags');
    }

    public function option(){

        return $this->hasMany(Option::class,'product_id');
    }



}
