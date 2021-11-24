<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = ['name', 'email', 'password', 'tenant_id'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
