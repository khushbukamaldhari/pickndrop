<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $fillable = ['id', 'st_meta_key', 'st_meta_value'];
}
