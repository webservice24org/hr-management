<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Position extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'position_name',
        'position_details',
        'status',
        'created_by',
        'updated_by',
    ];
}
