<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $fillable = [
        'class_id',
        'fee_type',
        'amount',
        'frequency',
        'description',
        'is_active',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    public function payments()
    {
        return $this->hasMany(FeePayment::class);
    }
}
