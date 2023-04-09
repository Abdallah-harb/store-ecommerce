<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeTranslation extends Model
{
    protected $table = 'product_attribute_translations';

    protected $fillable = ['attribute_id ','locale','name'];

    public $timestamps =false;
}
