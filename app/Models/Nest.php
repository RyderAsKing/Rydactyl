<?php

namespace App\Models;

use App\Models\Egg;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nest extends Model
{
    use HasFactory;

    public function egg()
    {
        return $this->hasMany(Egg::class);
    }
}
