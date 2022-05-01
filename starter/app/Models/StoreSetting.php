<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreSetting extends Model
{
    use HasFactory;

    protected $table = 'store_settings';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'store_id',
            'vat_included',
            'vat_percentage',
            'shipping_cost'
        ];

    protected $casts
        = [
            'vat_included' => 'boolean',
        ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
