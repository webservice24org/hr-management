<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'company_name',
        'email',
        'mobile',
        'country',
        'address',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
