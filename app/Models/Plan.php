<?php

namespace App\Models;


use App\Models\Subscription;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }
}
