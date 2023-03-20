<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgentReseller extends Model
{
    use HasFactory;
    protected $table = 'agen_reseller';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_reseller_id', 'id');
    }
    public function selling()
    {
        return $this->hasMany(Selling::class, 'user_id', 'user_reseller_id');
    }
}
