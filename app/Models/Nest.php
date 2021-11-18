<?php

namespace App\Models;

use App\Models\Egg;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nest extends Model
{
    use HasFactory;

    protected $fillable = [
        'nest_id',
        'name',
        'description',
        'uuid',
    ];

    public function egg()
    {
        return $this->hasMany(Egg::class);
    }
}
