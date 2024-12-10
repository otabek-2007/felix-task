<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_materials')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function warehouses()
    {
        return $this->hasMany(Warehouse::class);
    }
}
