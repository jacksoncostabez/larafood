<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Tenant\Traits\TenantTrait;

class Category extends Model
{
    use HasFactory;
    use TenantTrait;

    protected $fillable = ['name', 'url', 'description'];

    public function tenant()
    {
        return $this->hasMany(Tenant::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
