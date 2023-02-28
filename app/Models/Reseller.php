<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reseller extends Model
{
    use HasFactory;
    protected $table = 'resellers';
    protected $guarded = [];

    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}
