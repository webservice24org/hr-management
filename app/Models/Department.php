<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Casts\Attribute;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'department_name',
        'status',
        'created_by',
        'updated_by',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    // Accessor: returns "Active" or "Inactive"
    protected function statusText(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status ? 'Active' : 'Inactive'
        );
    }
}

