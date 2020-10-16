<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Immobile extends Model
{
    use HasFactory, SoftDeletes, UuidModel;

    protected $fillable = [
        'uuid',
        'email',
        'state',
        'city',
        'neighborhood',
        'street',
        'number',
        'complement',
    ];

    public function getRouteKeyName()
    {
        return 'uuid';
    }
}
