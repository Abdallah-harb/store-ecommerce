<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
   protected $table = 'admins';

   //  protected $guarded = []; if there are not anything's to hidden
   protected $fillable = ['name','email','password'];

   protected $hidden = ['created_at','updated_at'];

   public $timestamps =true;
}
