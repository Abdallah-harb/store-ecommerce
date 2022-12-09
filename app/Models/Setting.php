<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    // use package to translate
    use Translatable;

    //package to connect to columns
    protected $with = ['translations'];

    //column translate
    protected $translatedAttributes = ['value'];

    protected $table = 'settings';

    protected $fillable = ['key ','is_translatable','plain_value'];

    //make the value of is_translatble from [0 , 1 ] => to [true , false ] when I return it
    protected $casts = ['is_translatable' => 'boolean'];

    public $timestamps =true;

    //function to add data with seeder
    //add many data [but in settings variable and foreach it as key and value ]
    public static function setMany($settings){
        foreach ($settings as $key=>$value){
            self::set($key,$value);   //oop
        }
    }



    //set method work with setNany [take key and value and save to database ]
    public static function set($key,$value){
        if($key === 'translatable'){

            return static::setTranslatableSettings($value);
        }
        if(is_array($value)){
            $value = json_encode($value);
        }

        static::updateOrCreate(['key' => $key],['plain_value' => $value]);
    }

        //function setTranslatableSettings to create date
    public static function setTranslatableSettings($settings = []){
        foreach ($settings as $key => $value){
            static::updateOrCreate(
                ['key' => $key],
                [
                    'is_translatable'  => true,
                    'value'            => $value,
                ]);
        }
    }






}
