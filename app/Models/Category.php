<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'url', 'description'];

    public function tenant()
    {
        return $this->hasMany(Tenant::class);
    }
}
