<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreTranslation extends Model
{
    protected $table = 'store_translations';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'name'
        ];


}
