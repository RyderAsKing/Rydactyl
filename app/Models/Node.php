<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    use HasFactory;

    protected $fillable = [
        'panel_fqdn',
        'node_id',
        'name',
        'slots',
        'slots_used',
        'type', // 0 = for users
    ];
}
