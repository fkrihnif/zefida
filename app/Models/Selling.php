<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selling extends Model
{
    use HasFactory;
    protected $table = 'sellings';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function agent_reseller()
    {
        return $this->belongsTo(AgentReseller::class, 'user_id', 'user_reseller_id');
    }
}
