<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    protected $table = 'tag_translations';

    protected $fillable = ['tag_id ','locale','name'];

    public $timestamps =false;
}
