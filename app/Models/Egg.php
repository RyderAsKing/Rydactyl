<?php

namespace App\Models;

use App\Models\Nest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Egg extends Model
{
    use HasFactory;

    protected $fillable = [
        'egg_id',
        'nest_id',
        'name',
        'description',
        'uuid',
        'enabled',
    ];

    public function nest()
    {
        return $this->belongsTo(Nest::class);
    }
}
