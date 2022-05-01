<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, Translatable;

    protected $table = 'products';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'store_id',
            'price'
        ];

    protected $translatedAttributes
        = [
            'name',
            'description'
        ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 1000;
    }

    public function getPriceAttribute($value)
    {
        return $value / 1000;
    }

}
